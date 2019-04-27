<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //Table name
    protected $table = 'users';
    //Primary key
    public $primaryKey = 'id';
    //Timesamps
    public $timestamps = true;
    //fillable fields
    protected $fillable = [
        'name', 'last_name', 'email', 'password',
    ];

    protected $hidden = [
        'remember_token',
    ];
}
