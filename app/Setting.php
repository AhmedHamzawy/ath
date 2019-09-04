<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['about_ar' , 'about_en' , 'facebook' , 'twitter' , 'instagram' , 'youtube' , 'google_plus', 'phone' , 'conditions' , 'months' , 'order_no' , 'commission'];
}
