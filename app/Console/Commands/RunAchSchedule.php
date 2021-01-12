<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Payment;
use App\Models\AchSchedule;
use App\Models\StripePaymentTransaction;
use Illuminate\Support\Facades\DB;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentInvoice;
use PDF;

class RunAchSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:ach';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debit transactions from Card and transfer to Stripe';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $achSchedule = AchSchedule::first();
        if ($achSchedule->next_ach_date == date('Y-m-d')) {
            $users = User::where('role', 'merchant')->get();
            foreach ($users as $user) {
                if ($user->stripe_card_id) {
                    $charge = Stripe::charges()->create([
                        'customer' => $user->stripe_customer_id,
                        'currency' => 'USD',
                        'amount'   => $user->credit_balance,
                    ]);
                    $stripePaymentTransaction = new StripePaymentTransaction;
                    $stripePaymentTransaction->user_id = $user->id;
                    $stripePaymentTransaction->transaction_id = $charge['id'];
                    $stripePaymentTransaction->amount = $user->credit_balance;
                    if ($stripePaymentTransaction->save()) {
                        DB::table('users')->decrement('credit_balance', $user->credit_balance);
                        $paymentTransactions = Payment::where('user_id', $user->id)->where('status', 'unpaid')->get();
                        foreach ($paymentTransactions as $payment_transaction) {
                            $payment = Payment::find($payment_transaction->id);
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
                                $filePath = 'uploads/pdf/'.$user->firstname.'-PAID-'.date('Y-m-d H:i:s').'.pdf';
                                PDF::loadView('pdf.paid_invoice', $data)->save('public/'.$filePath);
                                Mail::to($payment->user->email)->send(new PaymentInvoice($filePath));
                                Mail::to(User::where('role', 'admin')->first()->email)->send(new PaymentInvoice($filePath));
                            }
                        }
                    }
                }
            }
        }
    }
}
