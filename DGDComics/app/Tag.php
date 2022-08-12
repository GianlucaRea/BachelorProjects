<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    protected $table = "tags";

    protected $fillable = [
        'tag_name'
    ];

    public function article(){
        return $this->belongsToMany('App\Article');
    }
}
