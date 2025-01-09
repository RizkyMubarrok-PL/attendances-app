<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;

class ClassController extends Controller
{
    public function index(Classes $classes) {
        $classes = $classes->paginate(20);
        
        return view('dashboard.datakelas', ['classes' => $classes]);
    }

    public function insert(Classes $classes, Request $request) {
        $validate = $request([
            'class_name' => 'required|string|unique,class_name',
        ]);

        $classes->insert([
            'class_name'
        ]);

        // return view() 
    }

    public function update(Classes $classes, int $class_id, Request $request) {
        $class = $classes->find($class_id);

        $validate = $request([
            'class_name' => 'requires|string|unique,class_name',
        ]);

        $class->update([
            'class_name' => $validate['class_name']
        ]);

        // return view()
    }

    public function delete(Classes $classes, int $class_id) {
        $class = $classes->find($class_id);

        $class->delete();

        // return view()
    }

    public function classByName(Classes $classes, Request $request) {
        $validate = $request->validate([
            'class_name' => 'string'
        ]);

        $searched_class = $classes->searchClasses($validate['class_name'])->paginate(15);


        // return view();
    }
}
