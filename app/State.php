<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name_ar','name_en'];
    
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}
