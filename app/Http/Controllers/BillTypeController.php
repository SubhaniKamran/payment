<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BillType;

class BillTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billTypes = BillType::paginate(5);
        return view('pages.bill_types', ['billTypes' => $billTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = '';
        if ($request->hasFile('logo')) {
            if ($request->file('logo')->isValid()) {
                $validated = $request->validate([
                    'logo' => 'mimes:jpeg,png|max:2048',
                ]);

                $imageName = time().'.'.$request->logo->extension();  
                $request->logo->move(public_path('uploads'), $imageName);
            }
        }

        $billType = new BillType;
        $billType->fill($request->all());
        $billType->logo = $imageName;

        if ($billType->save())  {
            return response()->json(array('message'=> 'Bill type added successfully.'), 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $billType = BillType::find($id);
        return response()->json(array('data'=> $billType), 200);
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
        $billType = BillType::find($id);
        $billType->name = $request->name;
        $billType->admin_transaction_fee = $request->admin_transaction_fee;
        if ($billType->save()) {
            return response()->json(array('message'=> 'Bill type updated successfully.'), 200);
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
        $billType = BillType::find($id);
        if ($billType->delete()) {
            return response()->json(array('message'=> 'Bill type deleted successfully.'), 200);
        }
    }
}
