<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;
    protected $table="groups";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_description',
    ];

    public function user(){
        return $this->belongsToMany('App\User');
    } 

    public function service(){
        return $this->belongsToMany('App\Service');
    }
}
