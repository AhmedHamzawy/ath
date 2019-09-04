<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id' , 'text'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }
}
