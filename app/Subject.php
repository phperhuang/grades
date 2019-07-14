<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $fillable = ['class', 'chinese', 'math', 'english','political', 'history', 'biology', 'describe_id', 'geography'];
}
