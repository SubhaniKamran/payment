<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MerchantService;
use App\Models\Payment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userCount = User::where('role', 'merchant')->count();
        $data['userCount'] = $userCount;
        $payment= Payment::count();
        $data['payment'] = $payment;
        $totalBillPaid = Payment::all()->sum('amount_received');
        $data['totalBillPaid'] = $totalBillPaid;
        $totalCommissionEarned = Payment::all()->sum('admin_commission');
        $data['totalCommissionEarned'] = $totalCommissionEarned;
        return view('dashboard')->with($data);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function merchantIndex()
    {
        $serviceCount = MerchantService::where('user_id',auth()->user()->id)->count();
        $data['merchantservice'] = $serviceCount;
        $totalBillPaid = Payment::where('user_id', auth()->user()->id)->get()->sum('amount_received');
        $data['totalBillPaid'] = $totalBillPaid;
        $totalCommissionEarned = Payment::where('user_id', auth()->user()->id)->get()->sum('merchant_commission');
        $data['totalCommissionEarned'] = $totalCommissionEarned;
        $nameOfBills = MerchantService::where('user_id', auth()->user()->id)->get();
        $data['nameOfBills'] = $nameOfBills;
        return view('merchant/dashboard')->with($data);
    }
}
