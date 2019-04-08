<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study_programs extends Model
{
    //Table name
    protected $table = 'study_programs';
    //Primary key
    public $primaryKey = 'id';
    //Timesamps
    public $timestamps = true;

    protected $fillable = [
        'study_program', 'study_form', 'study_program_abrv',
    ];

    function students(){
        return $this->hasMany('App\Students');
    }
}