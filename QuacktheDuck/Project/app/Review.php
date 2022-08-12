<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

   protected $table = "reviews";
   public $timestamps = false;
   protected $fillable = [
       'id_review_by_user',
       'id_document_reviewed',
       'stars_number',
   ];

    public function document(){

        return $this->belongsTo('App\Document','id_document_reviewed');
    }
    public function user(){

        return $this->belongsTo('App\User','id_review_by_user');
    }

}
