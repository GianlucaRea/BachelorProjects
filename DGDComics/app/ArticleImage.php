<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    public $timestamps = false;
    protected $table = "article_images";

    protected $fillable = [
        'article_id','image_name',
    ];

    public function article(){
        return $this->belongsTo("App\Article");
    }
}