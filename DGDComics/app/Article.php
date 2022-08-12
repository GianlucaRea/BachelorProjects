<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "articles";
    public $timestamps = false;
    protected $dateFormat = 'd-m-Y';

    protected $fillable = [
        'user_id','title','article_text'
    ];

    public function comment(){
        return $this->hasMany('App\Comment')->where('comment_parent', 0);
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tag(){
        return $this->belongsToMany('App\Tag');
    }

    public function articleImage(){
        return $this->hasOne('App\ArticleImage');
    }
}
