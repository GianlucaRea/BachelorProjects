<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table ="documents";
    protected $fillable = [
        'id',
        'id_user_document',
        'title',
        'highlighting',
        'university',
        'course',
        'subject',
        'source',
    ];
    public $timestamps = false;

    public function content(){
        return $this->hasOne('App\Content','id_doc');
    }

    public function tag(){
        return $this->hasMany('App\Tag','id_document');
    }

    public function review(){
        return $this->hasMany('App\Review','id_document_reviewed');
    }

    public function version(){
        return $this->hasMany('App\Version','id_document');
    }

    public function user(){
        return $this->belongsTo('App\User','id_user_document');
    }
}
