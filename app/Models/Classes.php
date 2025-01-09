<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = ['class_name'];

    public function searchClasses(string $search) {
        return $this->where('class_name', 'like', '%'. $search .'%');
    }
}
