<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\User;
use Auth;
use App\Http\Resources\StatusResource;
use Spatie\Activitylog\Models\Activity;


class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        return response()->json(["status" => true, "data" => StatusResource::collection($statuses)], 200, [] , JSON_NUMERIC_CHECK);
    }

    public function getStatuses()
    {
        $statuses = Status::paginate(5);
        return StatusResource::collection($statuses);
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
        $status = $request->input('status_id') !== null ? Status::findOrFail($request->status_id)
        : new Status;

        $status->name_ar = $request->input('name_ar');
        $status->name_en = $request->input('name_en');
        
        if($status->save()){
          if($request->input('status_id') !== null){ 
              activity()->log($user->name_ar.' '.'قام بالتعديل على إسم حالة التوافر'.' '.$status->name_ar);
          }else{
              activity()->log($user->name_ar.' '.'قام بإضافة حالة توافر جديدة'.' '.$status->name_ar);
          }
          return response()->json(["status" => true, "data" => new StatusResource($status)], 200, [] , JSON_NUMERIC_CHECK);
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
        $status = Status::findOrFail($id);

        if($status->delete()){
            activity()->log($user->name_ar.' '.'قام بحذف حالة التوافر'.' '.$status->name_ar);
            return response()->json(["status" => true, "deleted" => new StatusResource($status)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }
}
