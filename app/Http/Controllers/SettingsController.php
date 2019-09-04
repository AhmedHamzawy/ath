<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Http\Resources\SettingResource;

use Illuminate\Http\Request;


class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::findOrFail(1);
        return response()->json(["status" => true, "data" => new SettingResource($settings)]);
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 1)
    {
        $settings = Setting::findOrFail($id);
        

        $settings->about_ar = $request->input('about_ar');
        $settings->about_en = $request->input('about_en');
        $settings->facebook = $request->input('facebook');
        $settings->twitter = $request->input('twitter');
        $settings->instagram = $request->input('instagram');
        $settings->youtube = $request->input('youtube');
        $settings->google_plus = $request->input('google_plus');
        $settings->phone = $request->input('phone');
        $settings->conditions = $request->input('conditions');
        $settings->months = $request->input('months');
        $settings->order_no = $request->input('order_no');
        $settings->commission = $request->input('commission');


        
        if($settings->save()){
            return response()->json(["status" => true, "data" => new SettingResource($settings)]);
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
        //
    }
}
