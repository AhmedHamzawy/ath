<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\User;
use Auth;
use App\Http\Resources\StateResource;
use Spatie\Activitylog\Models\Activity;

class StatesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        return response()->json(["status" => true, "data" => StateResource::collection($states)], 200, [] , JSON_NUMERIC_CHECK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * NOTE: Store Holds Create And Update methods - Depends On $request->isMethod('put')  
     */
    public function store(Request $request)
    {
        $user =  User::findOrFail($request->get('user_add'));
        $state = $request->input('state_id') !== null ? State::findOrFail($request->state_id)
        : new State;

        $state->name_ar = $request->input('name_ar');
        $state->name_en = $request->input('name_en');
        
        if($state->save()){
          if($request->input('state_id') !== null){ 
              activity()->log($user->name_ar.' '.'قام بالتعديل على إسم الحالة'.' '.$state->name_ar);
          }else{
              activity()->log($user->name_ar.' '.'قام بإضافة حالة جديدة'.' '.$state->name_ar);
          }
          return response()->json(["status" => true, "data" => new StateResource($state)], 200, [] , JSON_NUMERIC_CHECK);
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
        $state = State::findOrFail($id);

        return new StateResource($state);
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
        $state = State::findOrFail($id);

        if($state->delete()){
            activity()->log($user->name_ar.' '.'قام بحذف الحالة '.' '.$state->name_ar);
            return response()->json(["status" => true, "deleted" => new StateResource($state)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }
    
     public function Storereview($id , Request $request){

        $userReview = Review::where('user_id' , $request->get('user_id'))->first();
        (bool)$activeUpdate = $request->get('active_update');

        if(!empty($userReview)){
       
            if($activeUpdate == null) { return response()->json(['status' => false]); }
       
            elseif($activeUpdate == 1){

            $userReview->user_id = $request->get('user_id');
            $userReview->doctor_id = $request->get('doctor_id');
            $userReview->reting = $request->get('rating');    
        }else{

            $userReview = new Review([
                'user_id' =>  $request->get('user_id'),
                'doctor_id' =>  $request->get('doctor_id'),
                'rating'  =>  $request->get('rating'),
            ]);
        }}


        return $userReview->save() ?  response()->json(["status" => true , $userReview->with(['user'])], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false]);
                
    }
}
