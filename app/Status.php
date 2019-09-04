<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name_ar','name_en'];
    
    
    public function doctor(){
        return $this->hasOne('App\Doctor');
    }
}
