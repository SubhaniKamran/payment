<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\AchSchedule;
use App\Models\StripePaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\BillType;
use App\Models\MerchantService;
use App\Models\DefaultCommission;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use PDF;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentInvoice;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billTypes = BillType::whereHas('merchantServices', function (Builder $query) {
            $query->where('user_id', auth()->user()->id);
        })->get();
        return view('pages.payment', ['billTypes' => $billTypes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $creditToBalance = $request->bill_amount + $request->admin_commission;
        $creditBalance = auth()->user()->credit_balance ?? 0;
        $creditLimit = auth()->user()->credit_limit ?? 0;
        $balanceLimit = (int)$creditBalance + (int)$creditToBalance;
        $filePath = 'uploads/pdf/'.auth()->user()->firstname.'-'.date('Y-m-d H:i:s').'.pdf';
        if ((int)$creditLimit >= $balanceLimit) {
            $payment = new Payment;
            $payment->fill($request->all());
            $payment->invoice = $filePath;
            if ($payment->save()) {
                auth()->user()->update(['credit_balance' => $balanceLimit]);
                $data = array(  
                                'invoice_number' => $payment->id,
                                'merchant_account' => $payment->user->card_number,
                                'bill_type' => $payment->billType->name,
                                'amount_received' => $payment->amount_received,
                                'admin_commission' => $payment->admin_commission,
                                'merchant_commission' => $payment->merchant_commission,
                                'customer_name' => $payment->customer_name,
                                'bill_account_number' => $payment->bill_account_number,
                                'transaction_date' => $payment->created_at,
                                'amount_due' => $creditToBalance,
                                'ach_date' => AchSchedule::find(1)->next_ach_date
                            );
                PDF::loadView('pdf.invoice', $data)->save($filePath);
                Mail::to($payment->user->email)->send(new PaymentInvoice($filePath));
                Mail::to(User::where('role', 'admin')->first()->email)->send(new PaymentInvoice($filePath));
                return redirect()->back()->with('message', 'Payment Added Successfully.');
            }
        } else {
            return redirect()->back()->withErrors("Your Credit Limit has exeeded. Please PAY NOW to take more payments.");
        }
    }


    public function calculatePyment(Request $req)
    {
        $data = $req->all();
        $billType = BillType::find($data['bill_type_id']);
        $marchent = MerchantService::where('user_id',auth()->user()->id)->where('bill_type_id',$data['bill_type_id'])->first();
        $totalCommission = $billType->admin_transaction_fee + $marchent->commission;
        $defaultCommission = DefaultCommission::where('name', 'admin_transaction_fee')->first();

        if ($totalCommission > $defaultCommission->commission) {
            $bill = $data['bill']+$totalCommission;
            return response()->json(array('total_bill'=> $bill, 'admin_commission' => $billType->admin_transaction_fee, 'merchant_commission' => $marchent->commission), 200);
        } else {
            $bill = $data['bill']+$defaultCommission->commission ;
            return response()->json(array('total_bill'=>$bill, 'admin_commission' => $defaultCommission->commission-$marchent->commission, 'merchant_commission' => $marchent->commission), 200);
        }

    }

    public function payNow()
    {
        $defaultCommission = DefaultCommission::where('name', 'instant_payment_fee')->first();
        $paymentTransactions = Payment::where('user_id', auth()->user()->id)->where('status', 'unpaid')->get();
        return view('pages.pay_now', ['instantPaymentFee' => $defaultCommission->commission, 'paymentTransactions' => $paymentTransactions]);
    }

    public function sendPayment(Request $request)
    {
        if (auth()->user()->stripe_card_id) {
            $amount = DefaultCommission::where('name', 'instant_payment_fee')->first()->commission + $request->amount;
            $charge = Stripe::charges()->create([
                'customer' => auth()->user()->stripe_customer_id,
                'currency' => 'USD',
                'amount'   => $amount,
            ]);
            $stripePaymentTransaction = new StripePaymentTransaction;
            $stripePaymentTransaction->user_id = auth()->user()->id;
            $stripePaymentTransaction->transaction_id = $charge['id'];
            $stripePaymentTransaction->amount = $amount;
            if ($stripePaymentTransaction->save()) {
                DB::table('users')->decrement('credit_balance', $request->amount);
                foreach ($request->payment_transactions as $payment_transaction) {
                    $payment = Payment::find($payment_transaction);
                    $payment->status = 'paid';
                    $payment->paid_at = date('Y-m-d H:i:s');
                    if ($payment->save()) {
                        $data = array( 
                            'invoice_number' => $payment->id,
                            'merchant_account' => $payment->user->card_number,
                            'bill_type' => $payment->billType->name,
                            'amount_received' => $payment->amount_received,
                            'admin_commission' => $payment->admin_commission,
                            'merchant_commission' => $payment->merchant_commission,
                            'customer_name' => $payment->customer_name,
                            'bill_account_number' => $payment->bill_account_number,
                            'transaction_date' => $payment->created_at,
                            'amount_due' => $payment->amount_received - $payment->merchant_commission
                        );
                        $filePath = 'uploads/pdf/'.auth()->user()->firstname.'-PAID-'.date('Y-m-d H:i:s').'.pdf';
                        PDF::loadView('pdf.paid_invoice', $data)->save($filePath);
                        Mail::to($payment->user->email)->send(new PaymentInvoice($filePath));
                        Mail::to(User::where('role', 'admin')->first()->email)->send(new PaymentInvoice($filePath));
                    }
                }
                return redirect()->back()->with('message', 'Credit paid successfully.');
            }
        } else {
            return redirect()->back()->withErrors("Please enter your Debit/Credit Card detials first.");
        }
        
    }

}
