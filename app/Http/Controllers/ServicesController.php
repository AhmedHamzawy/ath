<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ServiceFormRequest;
use App\Service;
use App\User;
use Auth;
use App\Http\Resources\ServiceResource;
use Spatie\Activitylog\Models\Activity;


class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::paginate(5);
        

        return ServiceResource::collection($services);
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
    public function store(ServiceFormRequest $request)
    {
        $user =  User::findOrFail($request->get('user_add'));
        $service = $request->input('service_id') !== null ? Service::findOrFail($request->service_id)
        : new Service;

        $service->id = $request->input('service_id');
        $service->name_ar = $request->input('name_ar');
        $service->name_en = $request->input('name_en');
        $service->active = 0;

        if($service->save()){
            if($request->input('service_id') !== null){ 
                activity()->log($user->name_ar.' '.'قام بالتعديل على إسم الخدمة'.' '.$service->name_ar);
            }else{
                activity()->log($user->name_ar.' '.'قام بإضافة خدمة جديدة'.' '.$service->name_ar);
            }
            return response()->json(["status" => true, "data" => new ServiceResource($service)], 200, [] , JSON_NUMERIC_CHECK);
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
        $service = Service::find($id);

        return !empty($service) ?  response()->json(["status" => true , "data" => $service->doctors ], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]) ;
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
        $service = Service::findOrFail($id);

        if($service->delete()){
            activity()->log($user->name_ar.' '.'قام بحذف الخدمة '.' '.$service->name_ar);
            return response()->json(["status" => true, "deleted" => new ServiceResource($service)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }
    
    
    public function allActiveServices(){

        $services = Service::where('active' , '1')->get();

//        dd($services);
         

        return !empty($services) ? response()->json(["status" => true , 'data' => ServiceResource::collection($services) ], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);
    }
}
