<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rating;
use App\Doctor;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RatingFormRequest;
use App\Http\Resources\UserResource;
use Carbon\Carbon;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('type' , 'client')->get();
        return response()->json(["status" => true, "data" => UserResource::collection($users)], 200, [] , JSON_NUMERIC_CHECK);
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
        $user = $request->input('user_id') !== null ? User::findOrFail($request->user_id)
        : new User;

        $validator = Validator::make($request->all(), [ 
            'name_ar' => 'required|unique:users,name_ar,'.$user->id, 
            'name_en' => 'unique:users,name_en,'.$user->id, 
            'email' => 'required|email|unique:users,email,'.$user->id, 
            'mobile' => 'required|unique:users,mobile,'.$user->id,
            'lat' => 'required',
            'lon' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) { 
            return response()->json(['status' => false , 'error'=>$validator->errors()], 500);            
        }else{

       
        $user->id = $request->input('user_id');
        $user->name_ar = $request->input('name_ar');
        $user->name_en = $request->input('name_en');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->lat = $request->input('lat');
        $user->lon = $request->input('lon');
        $user->address = $request->input('address');
        $user->type = "admin";
        $user->token = 0;
        $user->description_ar = $request->input('description_ar');
        $user->description_en = $request->input('description_en');
        $user->password = bcrypt($request->input('password'));

        if($request->input('image'))
        {
            $image = $request->input('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->input('image'))->save(public_path('images/').$name);
            $user->image = asset('images/'.$name);
        }else{
            $user->image = asset('images/default.png');
        }

        

        if($user->save()){
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
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
                'token' => $success['token'],
                'device_token' => $user->device_token,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
                 ]
                ]
                , 200, [] , JSON_NUMERIC_CHECK);

                
            }
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
        $user = User::find($id);
        return (!empty($user)) ?  response()->json(["status" => true , "user" => $user ], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false]);
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
        $user = User::findOrFail($id);

        if($user->delete()){
            return response()->json(["status" => true, "deleted" => new UserResource($user)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }

    public function changepassword(Request $request , $id){
        
        $user = User::findOrFail($id);

        $oldpassword = $request->input('old_password');

        if(Hash::check($oldpassword , $user->password)){

           $user->fill(['password' => Hash::make( $request->input('new_password'))])->save();

           return response()->json(["status" => true]);

        }else{
            return response()->json(["status" => false]);
        }


    }
    

    public function getRatings(){

        $ratings = Rating::where('rating' , '>' , 0)->with(['user','doctor'])->paginate(5);

        return response()->json(["status" => true, "data" => $ratings], 200, [] , JSON_NUMERIC_CHECK);

    }
    
    public function StoreRating($id , RatingFormRequest $request){

        $userRating = Rating::where('user_id' , $request->get('user_id'))->where('doctor_id' , $id)->first();
        $doctor = Doctor::find($id);
        
        if(empty($doctor)){ response()->json(["status" => false]);  }

        if(!empty($userRating)){
       


                $userRating->user_id = $request->get('user_id');
                $userRating->doctor_id = $id;
                $userRating->rating ^= 1;
                
                $userRating->rating == 0 ? $doctor->rating-- : $doctor->rating++; 
                
            
            
            }else{
    
                $userRating = new Rating([
                    'user_id' =>  $request->get('user_id'),
                    'doctor_id' =>  $id,
                    'rating'  =>  1,
                ]);
                
                $doctor->rating++;
            }

            if($doctor->save()){
            return $userRating->save() ?  response()->json(["status" => true , "rating" => $userRating  , "doctor" => $doctor ], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false]);
            }
    }
    
    public function upload(Request $request , $id){
        
        $user = User::findOrFail($id);
        
        if($request->file('image') == null){
            $user->image = asset('images/default.png'); 
        }else{
        
        $photo = $request->file('image')->getClientOriginalName();
        $destination = base_path().'/public/images/users';
        $request->file('image')->move($destination, $photo);
        $user->image = asset('images/users/'.$photo); 
        
        }    
        
        return $user->save() ?  response()->json(["status" => true , "user" => $user ], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false]);
        
    }
}
