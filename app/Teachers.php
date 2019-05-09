<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['birth_date', 'role', 'name', 'last_name'];
}
