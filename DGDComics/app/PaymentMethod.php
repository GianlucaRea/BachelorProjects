<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    public $timestamps = false;
    protected $table = "payment_methods";

    protected $fillable = [
        'user_id','payment_type', 'favourite', 'data_scadenza', 'cardNumber', 'intestatario', 'CVV'
    ];
    
    public function user(){
        return $this->belongsTo('App\User');
    }


    public function order(){
        return $this->belongsTo('App\Order');
    }

}
