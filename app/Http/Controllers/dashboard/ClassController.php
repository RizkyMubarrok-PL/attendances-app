<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;

class ClassController extends Controller
{
    public function index(Classes $classes)
    {
        $classes = $classes->orderBy('class_name', 'asc')->paginate(20);

        return view('dashboard.datakelas', ['classes' => $classes]);
    }

    public function insert(Classes $classes, Request $request)
    {
        $validate = $request->validate([
            'kelas' => 'required|string|unique:classes,class_name',
        ], [
            'kelas.required' => 'Bidang nama wajib diisi.',
            'kelas.string' => 'Bidang nama harus berupa teks.',
            'kelas.unique' => 'Bidang nama sudah ada.'
        ]);

        $class = $classes->create([
            'class_name' => $validate['kelas'],
        ]);

        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil menambahkan kelas baru.'
        ]);
    }

    public function update(Classes $classes, Request $request)
    {
        $validate = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'kelas' => 'required|string|unique:classes,class_name,class_id',
        ], [
            'class_id.required' => 'Bidang id wajib diisi.',
            'class_id.exists' => 'Class id tidak ada dalam table classes.',
            'kelas.required' => 'Bidang nama wajib diisi.',
            'kelas.string' => 'Bidang nama harus berupa teks.',
            'kelas.unique' => 'Bidang nama sudah ada.'
        ]);        

        $class_id = $validate['class_id'];

        $class = $classes->find($class_id);
        
        $class->update([
            'class_name' => $validate['kelas']
        ]);

        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil mengubah data kelas.'
        ]);
    }

    public function delete(Classes $classes, Request $request)
    {
        $validate = $request->validate([
            'class_id' => 'required|exists:classes,id'
        ], [
            'class_id.required' => 'Bidang id wajib diisi.',
            'class_id.exists' => 'Class id tidak ada dalam table classes.',
        ]);

        $class_id = $validate['class_id'];

        $class = $classes->find($class_id);

        $class->delete();

        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil menghapus data kelas.'
        ]);
    }

    public function classByName(Classes $classes, string $keyword)
    {

        $searched_class = $classes->searchClasses($keyword)->paginate(20);
        // dd($searched_class);

        return view('dashboard.datakelas', ['classes' => $searched_class]);
    }
}
