<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;

class TeacherClasses extends Model
{
    protected $fillable = ['class_id', 'teacher_id'];

    public function classData() {        
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
