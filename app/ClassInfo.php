<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassInfo extends Model
{
    //
    protected $table = 'class_info';

    protected $fillable = ['class_no', 'manager'];

    public function grades()
    {
        
    }
}
