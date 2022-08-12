<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $table = "admins";
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
    ];
}
