<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassStudents extends Model
{
    protected $fillable = ['class_id', 'student_id'];

    public function classData() {        
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
