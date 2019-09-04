<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\DoctorFormRequest;
use App\Doctor;
use App\User;
use App\Service;
use App\Role;
use App\Rating;
use App\Http\Resources\DoctorResource;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::all();
        return response()->json(["status" => true, "data" => DoctorResource::collection($doctors)] , 200, [] , JSON_NUMERIC_CHECK);

    }

    public function getDoctors()
    {
        $doctors = Doctor::paginate(5);
        return DoctorResource::collection($doctors);
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
    public function store(DoctorFormRequest $request)
    {
        $doctor = $request->input('doctor_id') !== null ? Doctor::findOrFail($request->doctor_id)
        : new Doctor;

        $doctor->user_id = $request->input('hospital_id');
        $doctor->service_id = $request->input('service_id');
        $doctor->name_ar = $request->input('name_ar');
        $doctor->name_en = $request->input('name_en');
        $doctor->certificate = $request->input('certificate');
        $doctor->dateofbirth = $request->input('dateofbirth');
        $doctor->cost = $request->input('cost');
        $doctor->image = asset('images/default.png'); 
        $doctor->description_ar = $request->input('description_ar');
        $doctor->description_en = $request->input('description_en');
        $doctor->rating = 0;
        $request->input('status_id') == null ?  :  $doctor->status_id = $request->input('status_id');
        
        
        if($request->input('image'))
        {
            $image = $request->input('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->input('image'))->save(public_path('images/').$name);
            $doctor->image = asset('images/'.$name);
        }else{
            $doctor->image = asset('images/default.png');
        }
        
        if($doctor->save()){
          return response()->json(["status" => true, "data" => new DoctorResource($doctor)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $doctor_id , $user_id)
    {
      
        $doctor = Doctor::where('id' , $doctor_id)->with('service')->with('status')->first();

        $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
        $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";

        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
        // Execute
        $hospitalCity=json_decode(curl_exec($ch) , true);

        // Arabic Info
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
        // Execute
        $hospitalCityArabic =json_decode(curl_exec($ch) , true);
        
        $doctor->user->city_ar = $hospitalCityArabic['results'][1]["address_components"][2]["long_name"];
        $doctor->user->city_en = $hospitalCity['results'][1]["address_components"][2]["long_name"];
        
        
        
        $rating = Rating::where('doctor_id' , $doctor_id)->where('user_id' , $user_id)->first();

        if($rating == null) {
            
            $rating = new Rating([
            
                "user_id" => $user_id,
                "doctor_id" => $doctor_id,
                "rating" => 0,
                
            ]);
            
            $rating->save();
        }
    
        return !empty($doctor) ? response()->json(["status" => true, "doctor" => $doctor , "rating" => $rating->rating ] , 200, [] , JSON_NUMERIC_CHECK) :  response()->json(["status" => false , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);
    }

    public function getDoctor(Request $request , $doctor_id)
    {
      
        $doctor = Doctor::where('id' , $doctor_id)->with('service')->with('status')->first();

        $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
        $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctor->user->lat.",".$doctor->user->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";

        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
        // Execute
        $hospitalCity=json_decode(curl_exec($ch) , true);

        // Arabic Info
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
        // Execute
        $hospitalCityArabic =json_decode(curl_exec($ch) , true);
        
        $doctor->user->city_ar = $hospitalCityArabic['results'][1]["address_components"][2]["long_name"];
        $doctor->user->city_en = $hospitalCity['results'][1]["address_components"][2]["long_name"];
        
        
    
    
        return !empty($doctor) ? response()->json(["status" => true, "doctor" => $doctor] , 200, [] , JSON_NUMERIC_CHECK) :  response()->json(["status" => false , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);
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
        $doctor = Doctor::findOrFail($id);

        if($doctor->delete()){
            return response()->json(["status" => true, "deleted" => new DoctorResource($doctor)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }

    public function offers(){

        $major = Doctor::max('cost');
        $least = $major/4;


        $offers = Doctor::where('cost' , '<=' , $least)->limit(20)->with('service')->orderBy('cost' , 'asc')->get();
        $res = [];
        
        foreach($offers as $offer){
            
            
            $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$offer->user->lat.",".$offer->user->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
            $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$offer->user->lat.",".$offer->user->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";

           //  Initiate curl
            $ch = curl_init();
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   

            // Set the url
            curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
            // Execute
            $hospitalCity=json_decode(curl_exec($ch) , true);

            // Arabic Info
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
            // Execute
            $hospitalCityArabic =json_decode(curl_exec($ch) , true);
            
            $offer->user->city_ar = $hospitalCityArabic['results'][1]["address_components"][2]["long_name"];
            $offer->user->city_en = $hospitalCity['results'][1]["address_components"][2]["long_name"];
            $offer->user->address_ar = $hospitalCityArabic['results'][1]["formatted_address"];
            $offer->user->address_en = $hospitalCity['results'][1]["formatted_address"];
       
            array_push($res , $offer); 
            //array_push($res , $offer->user); 
            
        }
        

        return !empty($offers) ? response()->json(["status" => true, "data" => $res], 200, [] , JSON_NUMERIC_CHECK) :  response()->json(["status" => false , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);
    }


    public function doctorsService($id){
       
        $doctorsservice = Service::find($id)->doctors()->get();

        return !empty($doctorsservice) ?  response()->json(["status" => true, "data" => DoctorResource::collection($doctorsservice)], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);

    }

    public function doctorsHospital($id){

        $doctorshospital = User::whereId($id)->with('doctors.service')->first();
    
        $hospitalGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctorshospital->lat.",".$doctorshospital->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
        $hospitalGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$doctorshospital->lat.",".$doctorshospital->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";

       //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfo);
        // Execute
        $hospitalCity=json_decode(curl_exec($ch) , true);

        // Arabic Info
        // Set the url
        curl_setopt($ch, CURLOPT_URL,$hospitalGeoInfoArabic);
        // Execute
        $hospitalCityArabic =json_decode(curl_exec($ch) , true);
        
        $doctorshospital->city_ar = $hospitalCityArabic['results'][1]["address_components"][2]["long_name"];
        $doctorshospital->city_en = $hospitalCity['results'][1]["address_components"][2]["long_name"];
        $doctorshospital->address_ar = $hospitalCityArabic['results'][1]["formatted_address"];
        $doctorshospital->address_en = $hospitalCity['results'][1]["formatted_address"];
                    
        return !empty($doctorshospital) ?  response()->json(["status" => true, "data" => $doctorshospital], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);

    }
    
    
    public function upload(Request $request , $id){
        
        $doctor = Doctor::findOrFail($id);
        
        if($request->file('image') == null){
            $doctor->image = asset('images/default.png'); 
        }else{
        
        $photo = $request->file('image')->getClientOriginalName();
        $destination = base_path().'/public/images/doctors';
        $request->file('image')->move($destination, $photo);
        $doctor->image = asset('images/doctors/'.$photo); 
        
        }    
        
        return $doctor->save() ?  response()->json(["status" => true , "doctor" => $doctor ], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false]);
        
    }
    
}
