<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;
    protected $table = "images";

    protected $fillable = [
        'comic_id','image_name','cover', 'imageNumber',
    ];

    public function comic(){
        return $this->belongsTo("App\Comic");
    }
}
