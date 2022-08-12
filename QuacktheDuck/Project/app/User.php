<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent;
use App\Document;
class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','surname', 'email', 'password', 'university','course'
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

    public function document(){
        return $this->hasMany('App\Document','id_user_document');
    }

    public function review(){
        return $this->hasMany('App\Review','id_review_by_user');
    }

    public function statistic(){
        return $this->belongsTo('App\Statistic','id');
    }

    public function getUniversity(){
        return $this->university;
    }

    public function getID(){
        return $this->id;
    }

}
