<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = "contents";
    public $timestamps = false;
    protected $fillable = [
        'id_doc',
        'type',
         'file',
    ];

    public function document(){
        return $this->belongsTo('App\Document','id_doc' );
    }
}
