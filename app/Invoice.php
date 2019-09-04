<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['hospital_id' , 'url', 'items', 'sort'];

    public function hospital(){
        return $this->belongsTo('App\User');
    }
}
