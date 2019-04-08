<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{

    //Table name
    protected $table = 'students';
    //Primary key
    public $primaryKey = 'id';
    //Timesamps
    public $timestamps = true;
    //fillable fields
    protected $fillable = [
        'name', 'last_name', 'email', 'study_program_id', 'course', 
    ];

    public function course(){
        return $this->belongsTo('App\Study_programs');
    }
}
