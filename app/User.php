<?php
namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
  use HasApiTokens, Notifiable , EntrustUserTrait;
/**
* The attributes that are mass assignable.
*
* @var array
*/
protected $fillable = [
'name_ar', 'name_en' , 'email', 'mobile' , 'lat' , 'lon' , 'address' , 'type' , 'description_ar' , 'description_en' , 'image' , 'token' , 'device_token' , 'password',
];
/**
* The attributes that should be hidden for arrays.
*
* @var array
*/
protected $hidden = [
'password', 'remember_token',
];


public function services()
{
    return $this->belongsToMany('App\Service');
}

public function doctors(){
  return $this->hasMany('App\Doctor');
}

public function comments(){
  return $this->hasMany('App\Comment');
}

public function ratings()
{
  return $this->hasMany('App\Rating');
}

public function hospitalOrders()
{
  return $this->hasMany('App\Order' , 'hospital_id');
}

public function clientOrders()
{
  return $this->hasMany('App\Order' , 'client_id');
}

public function invoices()
{
  return $this->hadMany('App\Invoice' , 'hospital_id');
}

}