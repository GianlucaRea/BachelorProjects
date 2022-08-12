<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = "rankings";
    public $timestamps = false;

    protected $fillable = [
        'user_id','feedback_number','stars_number','avg_stars','number_selling_products'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
