<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name_ar','name_en','active'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function doctors()
    {
        return $this->hasMany('App\Doctor');
    }
}
