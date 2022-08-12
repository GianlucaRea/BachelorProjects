<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notifications";
    public $timestamps = false;

    protected $fillable = [
        'user_id','notification_text','state','date', 'notification','idLink'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
