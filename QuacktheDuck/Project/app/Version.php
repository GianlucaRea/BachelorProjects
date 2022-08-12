<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    public $timestamps = false;
     protected $table = "versions";
     protected $fillable  = [
         'id_document',
       'version_number',
     ];

    public function document(){

        return $this->belongsTo('App\Document','id_document');
    }


}
