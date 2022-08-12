<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    protected $table = "tags";
    protected $fillable = [
        'id_document',
        'tag_name',
    ];

    public function document(){
        return $this->belongsTo('App\Document','id_document');
    }


}
