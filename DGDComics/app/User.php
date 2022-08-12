<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    protected $table="users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname','username', 'age', 'phone_number', 'email', 'password', 'partitaIva', 'attivita'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


public function comic(){
    return $this->hasMany('App\Comic');
}

public function order(){
    return $this->hasMany('App\Order');
}

public function wishlist(){
    return $this->hasOne('App\Wishlist');
}

public function article(){
    return $this->hasMany('App\Article');
}

public function comment(){
    return $this->hasMany('App\Comment');
}

public function access_log(){
    return $this->hasMany('App\AccessLog');
}

public function message(){
    return $this->hasMany('App\Message');
}

public function shipping_address(){
    return $this->hasMany('App\ShippingAddress');
}

public function payment_method(){
    return $this->hasMany('App\PaymentMethod');
}

 public function group(){
    return $this->belongsToMany('App\Group');
} 

public function ranking(){
    return $this->hasOne('App\Ranking');
}

public function review(){
    return $this->hasMany('App\Review');
}

public function notification(){
    return $this->hasMany('App/Notification');
}

    public function hasGroup($group = null) {
        $hasGroup = false;
        $hasGroup = !$this->group->filter(function($item) use ($group) {
            return $item->group_description == $group;
        })->isEmpty();
        return $hasGroup;
    }



}