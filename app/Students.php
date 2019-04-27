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
        'studies_program_code', 'group', 'identity_code', 'name', 'last_name', 'email'
    ];
}
