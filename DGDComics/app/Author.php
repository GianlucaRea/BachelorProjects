<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = "authors";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name_author',
      ];

    public function comic(){
        return $this->hasMany('App\Comic');
    }
}
