<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['client_id' , 'hospital_id' , 'doctor_id' , 'state_id' , 'name' , 'date_time' , 'lat' , 'lon' , 'phone' , 'cost' , 'commission_status' , 'other'];

    public function client(){
        return $this->belongsTo('App\User');
    }

    public function hospital(){
        return $this->belongsTo('App\User');
    }

    public function doctor(){
        return $this->belongsTo('App\Doctor');
    }
    
    public function state(){
        return $this->belongsTo('App\State');
    }
    
    
}
 