<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    public $timestamps = false;

    protected $fillable = [
        'user_id','article_id','answer', 'parent_comment',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function article(){
        return $this->belongsTo('App\Article');
    }

    public function replies()
    {
        return $this->hasMany('App\Comment', 'comment_parent');
    }

}
