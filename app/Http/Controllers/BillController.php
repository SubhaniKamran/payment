<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment = Payment::with('user','billType');
        if ($request->account_number) {
            $payment->where('bill_account_number', 'like', '%'.$request->account_number.'%');
        }
        if ($request->bill_type) {
            $payment->whereHas('billType', function ($query) use ($request){
                $query->where('name', 'like', '%'.$request->bill_type.'%');
            });
        }
        if ($request->merchant_name) {
            $payment->whereHas('user', function ($query) use ($request){
                $query->where('firstname', 'like', '%'.$request->merchant_name.'%');
            });
        }
        if ($request->customer_name) {
            $payment->where('customer_name', 'like', '%'.$request->customer_name.'%');
        }
        $payments = $payment->paginate(5);
        return view('bill.index', ['payments' => $payments, 
        'account_number' => $request->account_number, 
        'bill_type' => $request->bill_type, 
        'merchant_name' => $request->merchant_name, 
        'customer_name' => $request->customer_name]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function UserHistory(Request $request)
    {
        $payment = Payment::where('user_id', auth()->user()->id)->with('user','billType');
        if ($request->account_number) {
            $payment->where('bill_account_number', 'like', '%'.$request->account_number.'%');
        }
        if ($request->bill_type) {
            $payment->whereHas('billType', function ($query) use ($request){
                $query->where('name', 'like', '%'.$request->bill_type.'%');
            });
        }
        if ($request->merchant_name) {
            $payment->whereHas('user', function ($query) use ($request){
                $query->where('firstname', 'like', '%'.$request->merchant_name.'%');
            });
        }
        if ($request->customer_name) {
            $payment->where('customer_name', 'like', '%'.$request->customer_name.'%');
        }
        $payments = $payment->paginate(5);
        return view('bill.index', ['payments' => $payments, 
        'account_number' => $request->account_number, 
        'bill_type' => $request->bill_type, 
        'merchant_name' => $request->merchant_name, 
        'customer_name' => $request->customer_name]);
    }
}
