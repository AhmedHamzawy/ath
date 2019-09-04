<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Doctor extends Model
{
    use EntrustUserTrait;
    
    protected $fillable = ['user_id', 'service_id' ,'name_ar' , 'name_en' , 'certificate', 'dateofbirth', 'cost', 'description_ar', 'description_en', 'rating', 'image'];
    
    protected $hidden = ['state'];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function status()
    {
        return $this->belongsTo('App\Status');    
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
    
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
