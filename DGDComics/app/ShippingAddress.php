<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ShippingAddress extends Model
{
    protected $table = "shipping_addresses";
    public $timestamps = false;

    protected $fillable = [
        'user_id','via','città','civico','other_info', 'favourite', 'sede',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function order(){
        return $this->belongsTo('App\Order');
    }
}
