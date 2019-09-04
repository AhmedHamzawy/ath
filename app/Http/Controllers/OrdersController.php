<?php

namespace App\Http\Controllers;
use App\Order;
use App\User;
use Carbon\Carbon;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = User::has('hospitalOrders')->paginate(5);
        return UserResource::collection($orders);
    }
    public function showHosptialOrders($id){

        $orders = Order::where('hospital_id' , $id)->with(['client','hospital','doctor','state'])->paginate(5);
        return OrderResource::collection($orders);
    }
    public function store(Request $request)
    {
        $order = $request->input('order_id') !== null ? Order::findOrFail($request->order_id)
        : new Order;

        $order->client_id = $request->input('client_id');
        $order->hospital_id = $request->input('hospital_id');
        $order->doctor_id = $request->input('doctor_id');
        $order->state_id = 1;
        $order->name = $request->input('name');
        $order->date_time = $request->input('date_time');
        $order->lat = $request->input('lat'); 
        $order->lon = $request->input('lon'); 
        $order->phone = $request->input('phone'); 
        $order->cost = $request->input('cost'); 
        $order->other = $request->input('other');
        if($request->input('state_id') != null) {$order->state_id = $request->input('state_id');}
        
        if($order->save()){
          return response()->json(["status" => true, "data" => new OrderResource($order)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }
    public function show($id)
    {
        $order = Order::findOrFail($id)->with(['client','hospital','doctor','doctor.status','state'])->first();
        $order->time_en = $order->created_at->diffForHumans();
        Carbon::setLocale('ar');
        $order->time_ar = $order->created_at->diffForHumans();    
        return response()->json(["status" => true, "data" => $order ], 200, [] , JSON_NUMERIC_CHECK);

    }    
    public function clientorders($id){
        
        $orders = Order::where('client_id' , $id)->with(['client','hospital', 'doctor', 'doctor.status' , 'doctor.service' ,'state'])->get();
        
        
        foreach($orders as $order){
            
            $orderGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$order->lat.",".$order->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
            $orderGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$order->lat.",".$order->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
    
            //  Initiate curl
            $ch = curl_init();
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$orderGeoInfo);
            // Execute
            $orderCity=json_decode(curl_exec($ch) , true);
    
            // Arabic Info
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$orderGeoInfoArabic);
            // Execute
            $orderCityArabic =json_decode(curl_exec($ch) , true);
            
            $order->city_ar = $orderCityArabic['results'][1]["address_components"][1]["long_name"];
            $order->city_en = $orderCity['results'][1]["address_components"][1]["long_name"];
            $order->address_ar = $orderCityArabic['results'][1]["formatted_address"];
            $order->address_en = $orderCity['results'][1]["formatted_address"];
        
            
        }
        
        return !$orders->isEmpty() ?  response()->json(["status" => true, "data" => $orders], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);

    }
    
    // In Case Of Hospital Demanded That Order , That's Why I Use Client_id
    public function hospitalorders($id){
        
        $orders = Order::where('client_id' , $id)->with(['client', 'hospital' ,'doctor.service','doctor.status','state'])->get();
        
        foreach($orders as $order){
            
            $orderGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$order->lat.",".$order->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
            $orderGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$order->lat.",".$order->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
    
            //  Initiate curl
            $ch = curl_init();
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$orderGeoInfo);
            // Execute
            $orderCity=json_decode(curl_exec($ch) , true);
    
            // Arabic Info
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$orderGeoInfoArabic);
            // Execute
            $orderCityArabic =json_decode(curl_exec($ch) , true);
            
            $order->city_ar = $orderCityArabic['results'][1]["address_components"][1]["long_name"];
            $order->city_en = $orderCity['results'][1]["address_components"][1]["long_name"];
            $order->address_ar = $orderCityArabic['results'][1]["formatted_address"];
            $order->address_en = $orderCity['results'][1]["formatted_address"];
        
            
        }
        
        return !$orders->isEmpty() ?  response()->json(["status" => true, "data" => $orders], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);

    }
    
    
    public function doctororders($id){
        
        $orders = Order::where('doctor_id' , $id)->with(['client', 'hospital' ,'doctor.service','doctor.status','state'])->get();
        
        foreach($orders as $order){
            
            $orderGeoInfo  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$order->lat.",".$order->lon."&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
            $orderGeoInfoArabic  = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$order->lat.",".$order->lon."&language=ar&sensor=true&key=AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk";
    
            //  Initiate curl
            $ch = curl_init();
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$orderGeoInfo);
            // Execute
            $orderCity=json_decode(curl_exec($ch) , true);
    
            // Arabic Info
            // Set the url
            curl_setopt($ch, CURLOPT_URL,$orderGeoInfoArabic);
            // Execute
            $orderCityArabic =json_decode(curl_exec($ch) , true);
            
            $order->city_ar = $orderCityArabic['results'][1]["address_components"][1]["long_name"];
            $order->city_en = $orderCity['results'][1]["address_components"][1]["long_name"];
            $order->address_ar = $orderCityArabic['results'][1]["formatted_address"];
            $order->address_en = $orderCity['results'][1]["formatted_address"];
        
            
        }
        
        return !$orders->isEmpty() ?  response()->json(["status" => true, "data" => $orders], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false, "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Results Found"]);

    }
}
