<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefaultCommission;
use App\Models\AchSchedule;

class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $defaultCommission = DefaultCommission::all();
        $achSchedule = AchSchedule::first();
        return view('pages.setting', ['defaultCommission' => $defaultCommission, 'achSchedule' => $achSchedule]);
    }
    function update(Request $request)
    {
        if ($request->admin_transaction_fee) {
            $admin_transaction_fee = DefaultCommission::where('name', 'admin_transaction_fee')->first();
            $admin_transaction_fee->commission=$request->admin_transaction_fee;
            $admin_transaction_fee->save();
        }
        if ($request->instant_payment_fee) {
            $instant_payment_fee = DefaultCommission::where('name', 'instant_payment_fee')->first();
            $instant_payment_fee->commission=$request->instant_payment_fee;
            $instant_payment_fee->save();
        }

        return redirect()->back()->with('message', 'Fee Updated Successfully.');
    }

    public function updateAchSchdule(Request $request)
    {
        if (strtotime('next '.$request->day1) > strtotime('next '.$request->day2)) {
            $day = strtotime('next '.$request->day2);
          } else {
            $day = strtotime('next '.$request->day1);
          }
        $achSchedule = AchSchedule::first();
        $achSchedule->fill($request->all());
        $achSchedule->next_ach_date = date('Y-m-d',$day);
        if ($achSchedule->save()) {
            return redirect()->back()->with('message', 'ACH updated Successfully.');
        } else {
            return redirect()->back()->withErrors('Unable to update.');
        }
    }

}
