<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Comic extends Model
{
    
    
    protected $table = "comics";
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    public $timestamps = false;

    protected $fillable = [
        'user_id','author_id','comic_name','description','type','quantity','ISBN','price','discount','volume','height' ,'width', 'length','language','publisher','suggest'
    ];

    public function image(){
        return  $this->hasMany('App\Image');
    }

    public function genre(){
        return $this->belongsToMany('App\Genre');
    }

    public function author(){
        return $this->belongsTo('App\Author');
    }

    public function review(){
        return $this->hasMany('App\Review');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function comic_bought(){
        return $this->hasOne('App\ComicBought');
    }

    public function wishlist(){
        return $this->belongsToMany('App\Wishlist');
    }



}
