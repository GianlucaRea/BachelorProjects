<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    public $timestamps = false;
    protected $table = "statistics";
    protected $fillable = [
        'id_user',
    ];


    public function user()
    {
        return $this->hasMany('App\User', 'id_user');
    }

    /**
     * average_feedback_single_doc
     * average_feedback_total_doc
     * number_uploaded_doc
     * points_feedback_single_doc
     * points_feedback_total_doc
     * rank_position
     */




}
