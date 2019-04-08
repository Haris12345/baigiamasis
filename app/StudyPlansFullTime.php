<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyPlansFullTime extends Model
{
    //Table name
    protected $table = 'study_plans_full_time';
    //Primary key
    public $primaryKey = 'id';
    //Timesamps
    public $timestamps = true;
    //fillable fields
    protected $fillable = [
        'subject_name',
        'subject_code',
        'subject_status',
        'credits_sem1',
        'evaluation_type_sem1',
        'credits_sem2',
        'evaluation_type_sem2',
        'credits_sem3',
        'evaluation_type_sem3',
        'credits_sem4',
        'evaluation_type_sem4',
        'credits_sem5',
        'evaluation_type_sem5',
        'credits_sem6',
        'evaluation_type_sem6',
        'ECTS_credits',
    ];
}
