<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = "wishlists";
    public $timestamps = false;

    protected $fillable = [
        'user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comics(){
        return $this->belongsToMany('App\Comic');
    }
}
