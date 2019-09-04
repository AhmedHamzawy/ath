<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Doctor;
use App\User;
use Carbon\Carbon;
use App\Http\Resources\CommentResource;
use App\Http\Requests\CommentFormRequest;


class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with(['user','doctor'])->paginate(5);
        return CommentResource::collection($comments);
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
    public function store(CommentFormRequest $request)
    {
        $comment = new Comment();

        $comment->user_id = $request->input('user_id');
        $comment->doctor_id = $request->input('doctor_id');
        $comment->text = $request->input('text');
        
        
        if($comment->save()){
          return response()->json(["status" => true, "data" => new commentResource($comment)], 200, [] , JSON_NUMERIC_CHECK);
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
        $comment = Comment::findOrFail($id);

        if($comment->delete()){
            activity()->log($user->name_ar.' '.'قام بحذف التعليق '.' '.$comment->name_ar);
            return response()->json(["status" => true, "deleted" => new CommentResource($comment)], 200, [] , JSON_NUMERIC_CHECK);
        }
    }
    
    public function getDoctorComments($id){
        
        $comments = Comment::where('doctor_id' , $id)->with(['user'])->orderBy('created_at' , 'DESC')->get();
        foreach($comments as $comment){
            $comment->time_en = $comment->created_at->diffForHumans();
            Carbon::setLocale('ar');
            $comment->time_ar = $comment->created_at->diffForHumans();
        }

        return !$comments->isEmpty() ?  response()->json(["status" => true, "data" => $comments], 200, [] , JSON_NUMERIC_CHECK) : response()->json(["status" => false , "message_ar" => "لم يتم العثور على اي نتائج " , "message_en" => "No Result Found"]);        
    }

}
