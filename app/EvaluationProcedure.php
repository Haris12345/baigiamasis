<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluationProcedure extends Model
{
    //Table name
    protected $table = 'evaluation_procedure';
    //Primary key
    public $primaryKey = 'id';
    //Timesamps
    public $timestamps = true;
    //fillable fields
    protected $fillable = [
        'studies_program_code', 'subject_code', 'semester', 'credits', 'evaluation_type',
    ];
}
