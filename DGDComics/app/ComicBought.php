<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComicBought extends Model
{
    protected $table = "comic_boughts";
    public $timestamps = false;

    protected $fillable = [
        'comic_id', 'name', 'vendor', 'quantity', 'price', 'state'
    ];

    public function comic(){
        return $this->belongsToMany('App\Comic');
    }

    public function order(){
        return $this->belongsToMany('App\Order');
    }
}
