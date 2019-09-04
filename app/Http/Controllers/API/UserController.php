<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Role;
use App\Service;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller 
{
public $successStatus = 200;

/** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        $a = [];
        if(is_numeric(request('email'))){
            $a =  ['mobile'=>request('email'),'password'=>request('password')];
        }
        else{
            $a = ['email' => request('email'), 'password'=> request('password')];
        }
        if(Auth::attempt($a)){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $user->token = $success['token'];
            $created_at = new Carbon($user->created_at);
            $created_at = $created_at->toDateTimeString();
            $updated_at = new Carbon($user->updated_at);
            $updated_at = $updated_at->toDateTimeString();
            return response()->json(
                ['status' => true ,
                'user' => [
                'id' => $user->id,    
                'name_ar' => $user->name_ar,
                'name_en' => $user->name_en,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'lat' => $user->lat,
                'lon' => $user->lon,
                'address' => $user->address,
                'language' => $user->language,
                'type' => $user->type,
                'image' => $user->image,
                'token' => $user->token,
                'device_token' => $user->device_token,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
                 ]
                ]
            ); 
        } 
        else{ 
            return response()->json(
                [ 'status' => false , 'error_ar'=>'خطا فى بيانات الدخول' , 'error_en' => 'Credintials do not match our records']
            ); 
        } 
    }
/** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
         
        $email = User::where('email' , $request->input('email'))->get();
        $mobile = User::where('mobile' , $request->input('mobile'))->get();
        
        $a = array();

        if(!$email->isEmpty()){
            $a["error_ar"][0] = "البريد الإلكترونى قد تم إضافته من قبل";
            $a["error_en"][0] = "Email Has Been Taken";
        }
        
        if(!$mobile->isEmpty()){
            $a["error_ar"][1] = "الجوال قد تم إضافته من قبل";
            $a["error_en"][1] = "Mobile Has Been Taken";
        }
        
        if(!empty($a)){return response()->json(['status' => false , 'errors' => $a],401);}

        else{
        $input = $request->all();
       
        $input['password'] = bcrypt($input['password']); 
        $input['image'] = asset('images/default.png'); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $user->token = $success['token'];
        $success['name'] =  $user->name;

        $hospital = Role::where('name' , 'hospital')->firstOrFail();
        $client = Role::where('name' , 'client')->firstOrFail();
        if($user->type == 'hospital') {
            if(!empty($input['service_id'])){
                $service = Service::find($input['service_id']);
                $user->attachRole($hospital);
                $user->services()->attach($service->id);
            }
        }elseif($user->type == 'client'){
            $user->attachRole($client);
        }

        
         $created_at = new Carbon($user->created_at);
         $created_at = $created_at->toDateTimeString();
         $updated_at = new Carbon($user->updated_at);
         $updated_at = $updated_at->toDateTimeString();        
        return response()->json(
            ['status' => true ,
                'user' => [
                'id' => $user->id,    
                'name_ar' => $user->name_ar,
                'name_en' => $user->name_en,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'lat' => $user->lat,
                'lon' => $user->lon,
                'address' => $user->address,
                'type' => $user->type,
                'image' => $user->image,
                'token' => $user->token,
                'device_token' => $user->device_token,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
                ]
            ]
        ); 
        }
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    public function passwordReset(Request $request){

        $user = User::where('email' , $request->input('email'))->firstOrFail();
        
        if(!empty($user)){
            $randomPassword = str_random(8);
            $user->password = Hash::make(str_random(8));
    
            $title = 'Reset Password';
            $content = 'The New Password is'.$randomPassword;
    
    
            Mail::send('send', ['title' => $title, 'content' => $content , 'target' => $user], function ($message) use ($user)
            {
    
                $message->from('athomecare@domain.com', 'At Home Care username');
    
                $message->to($user->email);
    
            });
            
            return response()->json(["status" => true]);

        }else{
            return response()->json(["status" => false]);
        }
        

      

    }
}