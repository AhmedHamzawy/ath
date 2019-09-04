<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Role;
use App\Service;
use App\Doctor;
use App\Http\Resources\HospitalResource;
use DB;

class HospitalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospitals = User::where('type' , 'hospital')->get();
        return response()->json(["status" => true, "data" => HospitalResource::collection($hospitals)], 200, [] , JSON_NUMERIC_CHECK);
    }

    public function getHospitals()
    {
        $hospitals = User::where('type' , 'hospital')->paginate(5);
        return HospitalResource::collection($hospitals);
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
        $hospital = $request->input('hospital_id') !== null ? User::findOrFail($request->hospital_id)
        : new User;

        $hospital->id = $request->input('hospital_id');
        $hospital->name_ar = $request->input('name_ar');
        $hospital->name_en = $request->input('name_en');
        $hospital->email = $request->input('email');
        $hospital->mobile = $request->input('mobile');
        $hospital->lat = $request->input('lat');
        $hospital->lon = $request->input('lon');
        $hospital->address = $request->input('address');
        $hospital->type = "hospital";
        $hospital->token = 0;
        $hospital->password = bcrypt(request('password'));
        
        if($request->input('image'))
        {
            $image = $request->input('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->input('image'))->save(public_path('images/').$name);
            $hospital->image = asset('images/'.$name);
        }else{
            $hospital->image = asset('images/default.png');
        }
        
        if($hospital->save()){
            return response()->json(["status" => true, "data" => new HospitalResource($hospital)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $clientGeoInfo = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$request->get('lat').",".$request->get('lon')."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
        
        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$clientGeoInfo);
        // Execute
        $clientCity=json_decode(curl_exec($ch) , true);
        
        if($request->get('hospital_name') == null){

            $hospitals = User::where('type' , 'hospital')->with('doctors.service')->get();
            $res = [];
            
            
            foreach($hospitals as $hospital){
                
                $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$hospital->lat.",".$hospital->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
                $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$hospital->lat.",".$hospital->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
                
                // Set the url
                curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
                // Execute
                $hospitalCity=json_decode(curl_exec($ch) , true);
                
                // Arabic Info
                // Set the url
                curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
                // Execute
                $hospitalCityArabic =json_decode(curl_exec($ch) , true);
                
                
                
                if($hospitalCity['results'][1]["address_components"][2]["long_name"] == $clientCity['results'][1]["address_components"][2]["long_name"]){
                    $hospital->city_ar = $hospitalCityArabic['results'][1]["address_components"][1]["long_name"];
                    $hospital->city_en = $hospitalCity['results'][1]["address_components"][1]["long_name"];
                    $hospital->address_ar = $hospitalCityArabic['results'][1]["formatted_address"];
                    $hospital->address_en = $hospitalCity['results'][1]["formatted_address"];
                    array_push($res , $hospital); 
                }
            }
            // Closing
                curl_close($ch);   
            return empty($res) ?  response()->json(["status" => false  , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found" ]) :  response()->json(["status" => true,  "data"  => $res ], 200, [] , JSON_NUMERIC_CHECK); 
        
        }
        
        else{
        
            //Init Var
            $hospital_name = $request->get('hospital_name');
    
            //Process
            $this->is_arabic($hospital_name) ? $input = 'name_ar' : $input = 'name_en';
            $hospital = User::where('type' , 'hospital')->where($input , $hospital_name) ->orWhere($input, 'like', '%' . $hospital_name . '%')->with('doctors.service')->first();        
            
            if(empty($hospital)) {return response()->json(["status" => false  , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);  }
            
            $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$hospital->lat.",".$hospital->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
            $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$hospital->lat.",".$hospital->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
            
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
            // Execute
            $hospitalCity=json_decode(curl_exec($ch) , true);
            
            // Arabic Info
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
            // Execute
            $hospitalCityArabic =json_decode(curl_exec($ch) , true);
            
            // Closing
            curl_close($ch);   
        
        
            if($hospitalCity['results'][1]["address_components"][2]["long_name"] != $clientCity['results'][1]["address_components"][2]["long_name"]){
               
               return response()->json(["status" => false  , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found" ]); 
                  
            }else{
                
              $hospital->city_ar = $hospitalCityArabic['results'][1]["address_components"][1]["long_name"];
              $hospital->city_en = $hospitalCity['results'][1]["address_components"][1]["long_name"];
              $hospital->address_ar = $hospitalCityArabic['results'][1]["formatted_address"];
              $hospital->address_en = $hospitalCity['results'][1]["formatted_address"];
              return response()->json(["status" => true,  "data" => [$hospital] ] , 200, [] , JSON_NUMERIC_CHECK); 
            }
        
        
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
    public function destroy($id)
    {
        $hospital = User::findOrFail($id);

        if($hospital->delete()){
            return response()->json(["status" => true, "deleted" => new HospitalResource($hospital)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }
    
    
    public function serviceDoctorsHospitals(Request $request){

    if($request->input('service_name') == null){
    
      $services = Service::all();
    
      $clientGeoInfo = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$request->get('lat').",".$request->get('lon')."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";

      //  Initiate curl
      $ch = curl_init();
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Set the url
      curl_setopt($ch, CURLOPT_URL,$clientGeoInfo);
      // Execute
      $clientCity=json_decode(curl_exec($ch) , true);
      $res =[];

    foreach($services as $service){
        foreach($service->doctors as $doctor){
                
                
                $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
                $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
    
                // Set the url
                curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
                // Execute
                $hospitalCity=json_decode(curl_exec($ch) , true);
    
                // Arabic Info
                // Set the url
                curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
                // Execute
                $hospitalCityArabic =json_decode(curl_exec($ch) , true);
                

                if($hospitalCity['results'][1]["address_components"][2]["long_name"] === $clientCity['results'][1]["address_components"][2]["long_name"]){
                    
                    
                    //for only showing service eloquent relation in the API
                    $service = $doctor->service;
                    
                    $newdoctor = Doctor::find($doctor->id);
                    $newdoctor->state = 1;
                    $newdoctor->save();
                    
                    $doctor->user->city_ar = $hospitalCityArabic['results'][1]["address_components"][2]["long_name"];
                    $doctor->user->city_en = $hospitalCity['results'][1]["address_components"][2]["long_name"];
                    $doctor->user->address_ar = $hospitalCityArabic['results'][1]["formatted_address"];
                    $doctor->user->address_en = $hospitalCity['results'][1]["formatted_address"];
                    
                    $res[$doctor->user->id]['city_ar'] = $doctor->user->city_ar;
                    $res[$doctor->user->id]['city_en'] = $doctor->user->city_en; 
                    $res[$doctor->user->id]['address_ar'] = $doctor->user->address_ar; 
                    $res[$doctor->user->id]['address_en'] = $doctor->user->address_en; 


                    
                }else{
                    $newdoctor = Doctor::find($doctor->id);
                    $newdoctor->state = 0;
                    $newdoctor->save();
                }
                
                
                
                    
        }
        
    }
    
    $services = Service::with(array('doctors' => function($query)
    {
         $query->where('doctors.state', 1);
    } , 'doctors.user'))->get();
    
    $services = $services->filter(function ($element) {
    return !$element->doctors->isEmpty();
    })->values()->all();
    
    
    foreach($services as $service){
        foreach($service->doctors as $doctor){
            foreach($res as $key=>$value){
                if($key == $doctor->user->id){
                    $doctor->user->city_ar = $value['city_ar'];
                    $doctor->user->city_en = $value['city_en'];
                    $doctor->user->address_ar = $value['address_ar'];
                    $doctor->user->address_en = $value['address_en'];
                }
            }
        }
    }
    
    return !empty($services) ?  response()->json(["status" => true, "data" => $services], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);

}else{

    if($this->is_arabic($request->input('service_name'))){$value = 'name_ar';}else{$value = 'name_en';}
    $service = Service::where($value , $request->input('service_name'))->orWhere($value, 'like', '%' . $request->input('service_name') . '%')->first();

    if(empty($service)){return response()->json(["status" => false]);}


    $clientGeoInfo = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$request->get('lat').",".$request->get('lon')."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";

    //  Initiate curl
    $ch = curl_init();
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$clientGeoInfo);
    // Execute
    $clientCity=json_decode(curl_exec($ch) , true);
    $res =[];

    foreach($service->doctors as $doctor){

        $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
        $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";

        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
        // Execute
        $hospitalCity=json_decode(curl_exec($ch) , true);

        // Arabic Info
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
        // Execute
        $hospitalCityArabic =json_decode(curl_exec($ch) , true);


          
        if($hospitalCity['results'][1]["address_components"][2]["long_name"] === $clientCity['results'][1]["address_components"][2]["long_name"]){
            
            
            //for only showing service eloquent relation in the API
            $service = $doctor->service;
            
            $newdoctor = Doctor::find($doctor->id);
            $newdoctor->state = 1;
            $newdoctor->save();
            
            $doctor->user->city_ar = $hospitalCityArabic['results'][1]["address_components"][2]["long_name"];
            $doctor->user->city_en = $hospitalCity['results'][1]["address_components"][2]["long_name"];
            $doctor->user->address_ar = $hospitalCityArabic['results'][1]["formatted_address"];
            $doctor->user->address_en = $hospitalCity['results'][1]["formatted_address"];
            
            $res[$doctor->user->id]['city_ar'] = $doctor->user->city_ar;
            $res[$doctor->user->id]['city_en'] = $doctor->user->city_en; 
            $res[$doctor->user->id]['address_ar'] = $doctor->user->address_ar; 
            $res[$doctor->user->id]['address_en'] = $doctor->user->address_en; 


            
        }else{
            $newdoctor = Doctor::find($doctor->id);
            $newdoctor->state = 0;
            $newdoctor->save();
        }
    
                

    }
    
    
    $service = Service::where($value , $request->input('service_name'))->orWhere($value, 'like', '%' . $request->input('service_name') . '%')->whereHas('doctors')->with(array('doctors' => function($query)
    {
         $query->where('doctors.state', 1);
    } , 'doctors.user'))->first();
    
    
    
    // Check first if service exists before we complete the process
    if(empty($service)) { return response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]); }
    
    
        foreach($service->doctors as $doctor){
            foreach($res as $key=>$value){
                if($key == $doctor->user->id){
                    $doctor->user->city_ar = $value['city_ar'];
                    $doctor->user->city_en = $value['city_en'];
                    $doctor->user->address_ar = $value['address_ar'];
                    $doctor->user->address_en = $value['address_en'];
                }
            }
        }
    
    
    curl_close($ch);   

    return !empty($service->doctors) ?  response()->json(["status" => true, "data" => [$service] ], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);

}


    }
    
    
    function is_arabic($string) {
	   return preg_match('/\p{Arabic}/u', $string);
    }

    
}
