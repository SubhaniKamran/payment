<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BillType;
use App\Models\MerchantService;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterUser;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        $user = User::where('role', 'merchant');
        if ($request->search) {
            $user->where('firstname', 'like', '%'.$request->search.'%');
            $user->orWhere('lastname', 'like', '%'.$request->search.'%');
            $user->orWhere('email', 'like', '%'.$request->search.'%');
            $user->orWhere('phone', 'like', '%'.$request->search.'%');
        }
        $users = $user->with('merchantServices')->withTrashed()->paginate(5);
        $billTypes = BillType::all();
        return view('users.index', ['users' => $users, 'billTypes' => $billTypes, 'search' => $request->search]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
        ]);
        
        $password = mt_rand(100000, 999999);
        $user = User::where('email', $request->email)->onlyTrashed()->first();
        if (empty($user)) {
            $user = new User;
        }
        $user->fill($request->all());
        $user->password = Hash::make($password);
        $user->deleted_at = null;
        if ($user->save())  {
            Mail::to($request->email)->send(new RegisterUser($request->email, $password));
            return response()->json(array('message'=> 'Merchant added successfully.'), 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json(array('data'=> $user), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id)->withTrashed();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->credit_limit = $request->credit_limit;
        if ($user->save()) {
            return response()->json(array('message'=> 'Merchant updated successfully.'), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $payment = Payment::where('user_id', $user->id)->first();

        if($payment === null)
        {
            $user->status = "unverified";
            $user->save();
            if ($user->delete()) {
                return response()->json(array('message'=> 'User deleted successfully.'), 200);
            }
        }else
        {
            if ($user->delete()) {
                return response()->json(array('message'=> 'User deleted successfully.'), 200);
            }
        }

    }

    public function verify($id)
    {
        $user = User::find($id);
        if ($user) {
            $customer = Stripe::customers()->create([
                'email' => $user->email,
            ]);
            if ($customer['id']) {
                $user->stripe_customer_id = $customer['id'];
                $user->status = 'verified';
                $user->save();
                return response()->json(array('message'=> 'User verified successfully.'), 200);
            } else {
                return response()->json(array('message'=> 'Unable to verify user.'), 404);
            }
        } else {
            return response()->json(array('message'=> 'User not found.'), 404);
        }
    }

    public function assignServices(Request $request)
    {
        $data = $request->all();
        foreach ($data['services'] as $key => $service) {
            if (isset($service['bill_type_id']) && $service['bill_type_id'] == 'on') {
                $serviceExist = MerchantService::where('user_id', $data['user_id'])->where('bill_type_id', $key)->first();
                if (empty($serviceExist)) {
                    $serviceExist = new MerchantService;
                }
                if (empty($service['commission'])) {
                    return response()->json(array('message'=> 'Please Enter Commission value.'), 401);
                }
                $serviceExist->user_id = $data['user_id'];
                $serviceExist->bill_type_id = $key;
                $serviceExist->commission = $service['commission'];
                $serviceExist->save();
            }
        }
        return response()->json(array('message'=> 'Commission added successfully'), 200);
    }

    public function getServices($id)
    {
        $services = MerchantService::where('user_id', $id)->get();
        return response()->json(array('data'=> $services), 200);
    }

    public function deleteServices($id)
    {
        $services = MerchantService::find($id);
        $services->delete();
        return response()->json(array('message'=> 'Service Removed successfully'), 200);
    }

    public function addCardToStripe(Request $request)
    {
        $data = $request->all();
        $user = User::find($data['id']);
        unset($data['id']);
        try {
            $token = Stripe::tokens()->create([
                'card' => [
                    'number'    => $data['card_number'],
                    'exp_month' => $data['card_exp_month'],
                    'cvc'       => $data['card_cvc'],
                    'exp_year'  => $data['card_exp_year'],
                ],
            ]);
            $card = Stripe::cards()->create($data['stripe_customer_id'], $token['id']);
            $user->fill($data);
            $user->stripe_card_id = $card['id'];
            if ($user->save()) {
                return redirect()->back()->with('message', 'Card Added Successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }



    public function showData()
    {
        if(auth()->user()->role == 'admin'){
            $userCount = User::where('role', 'merchant')->count();
        }
    }


    public function unlockBannedUser($id)
    {

        $user = User::onlyTrashed()->find($id);

        if($user->deleted_at !== null && $user->status === "verified")
        {

            $user->deleted_at = null;
            if($user->save()){
                return response()->json(array('message'=> 'Merchant Account Un-Locked'), 200);
            }

        }
    }
}
