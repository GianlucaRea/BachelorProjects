<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $timestamps = false;
    protected $table = "genres";
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name_genre',
    ];

    public function comic(){
        return $this->belongsToMany('App\Comic');
    }
}
