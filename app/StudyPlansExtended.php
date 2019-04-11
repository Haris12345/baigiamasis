<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyPlansExtended extends Model
{
    protected $table = 'study_plans_extended';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $dillable = [
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
        'credits_sem7',
        'evaluation_type_sem7',
        'credits_sem8',
        'evaluation_type_sem8',
        'ECTS_credits',
    ];
}
