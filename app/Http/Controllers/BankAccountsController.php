<?php

namespace App\Http\Controllers;

use App\BankAccount;
use Auth;
use App\User;
use App\Http\Resources\BankAccountResource;

use Illuminate\Http\Request;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankaccounts = BankAccount::paginate(5);
        
        return BankAccountResource::collection($bankaccounts);
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
        $user =  User::findOrFail($request->get('user_add'));
        $bankaccount = $request->input('bankaccount_id') !== null ? BankAccount::findOrFail($request->bankaccount_id)
        : new BankAccount;

        $bankaccount->name = $request->input('name');
        $bankaccount->iban = $request->input('iban');

        if($bankaccount->save()){
            if($request->input('bankaccount_id') !== null){ 
                activity()->log($user->name_ar.' '.'قام بالتعديل على حساب البنك '.' '.$bankaccount->name);
            }else{
                activity()->log($user->name_ar.' '.'قام بإضافة حساب  بنكى جديد'.' '.$bankaccount->name);
            }
            return new BankAccountResource($bankaccount);         
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$user_id)
    {
        $user =  User::findOrFail($user_id);
        $bankaccount = BankAccount::findOrFail($id);

        if($bankaccount->delete()){
            activity()->log($user->name_ar.' '.'قام بحذف حساب البنك '.' '.$bankaccount->name);
            return new BankAccountResource($bankaccount);
        }
    }
}
