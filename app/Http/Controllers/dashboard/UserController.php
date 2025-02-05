<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\ClassStudents;
use App\Models\TeacherClasses;
use App\Rules\EnumStatus;
use App\EnumRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(User $users, Classes $classes)
    {
        $users = $users->with(['studentClass', 'teacherClasses'])->paginate(20);
        $classes = $classes->all();

        return view('dashboard.datauser', compact('users', 'classes'));
    }

    public function insert(Request $request, User $users, ClassStudents $classStudent, TeacherClasses $teacherClasses)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'role' => ['required', 'string', Rule::enum(EnumRole::class)],
            'class' => [
                Rule::when($request->role === 'siswa' || $request->role === 'suru', ['required', 'integer', 'exists:classes,id']),
                Rule::when($request->role === 'guru', ['array']), ['required'],
            ],'class.*' => [
                Rule::when($request->role === 'guru', ['integer', 'distinct', 'exists:classes,id']),
            ],
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email was already exists.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a valid string.',
            'role.required' => 'The role field is required.',
            'role.string' => 'The role must be a valid string.',
            'class.required' => 'The class field is required when the role is Siswa or Suru.',
            'class.integer' => 'The class must be an integer when the role is Siswa or Suru.',
            'class.exists' => 'The selected class does not exist.',
            'class.array' => 'The class field must be an array when the role is Guru.',
            'class.*.integer' => 'Each class must be an integer.',
            'class.*.distinct' => 'Each class must be unique.',
            'class.*.exists' => 'One or more selected classes do not exist.',
        ]);

        // buat data user baru
        $user = $users->create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'role' => $validate['role']
        ]);

        if ($validate['role'] == 'siswa') {
            $classStudent->insert([
                'student_id' => $user->id,
                'class_id' => $validate['class']
            ]);
        }
        
        if ($validate['role'] == 'guru') {            
            foreach ($validate['class'] as $item){
                $teacherClasses->insert([
                    'teacher_id' => $user->id,
                    'class_id' => $item
                ]);
            }
        }

        // kembali ke halaman user
        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil menambahkan user baru.'
        ]);
    }

    public function update(Request $request, User $users, Classes $classes, ClassStudents $classStudent, TeacherClasses $teacherClasses)
    {
        // set password input menjadi string ''
        $request->merge([
            'password' => $request->password ?? '',
        ]);
        // validasi input

        // dd($request);
        $validate = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'string',
            'role' => ['required', 'string', Rule::enum(EnumRole::class)],
            'class' => [
                Rule::when($request->role === 'siswa', ['required', 'integer', 'exists:classes,id']),
                Rule::when($request->role === 'guru', ['required', 'array']),
            ],'class.*' => [
                Rule::when($request->role === 'guru', ['integer', 'distinct', 'exists:classes,id']),
            ],
        ], [
            'user_id.required' => 'The user id is required',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email was already exists.',
            'password.string' => 'The password must be a valid string.',
            'role.required' => 'The role field is required.',
            'role.string' => 'The role must be a valid string.',
            'class.required' => 'The class field is required when the role is Siswa or Guru.',
            'class.integer' => 'The class must be an integer when the role is Siswa or Guru.',
            'class.exists' => 'The selected class does not exist.',
            'class.array' => 'The class field must be an array when the role is Guru.',
            'class.*.integer' => 'Each class must be an integer.',
            'class.*.distinct' => 'Each class must be unique.',
            'class.*.exists' => 'One or more selected classes do not exist.',
        ]);

        // dd($validate);

        $user_id = $validate['user_id'];

        // cari user
        $user = $users->find($user_id);

        // update user
        $user->update([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'role' => $validate['role']
        ]);

                
        if ($user->role === 'siswa') {
            $classStudent->where('student_id', $user->id)->delete();
            $classId = $validate['class'];
            $data = ['student_id' => $user->id, 'class_id' => $classId];            
            
            $classStudent->insert($data);
        } else {
            $classStudent->where('student_id', $user->id)->delete();            
        }
        
        
        if ($user->role == 'guru') {
            $teacherClasses->where('teacher_id', $user->id)->delete();
            $data = [];

            foreach($validate['class'] as $item) {
                $data[] = [
                    'teacher_id' => $user->id,
                    'class_id' =>  $item
                ];
            }

            $teacherClasses->insert($data);
        } else {
            $teacherClasses->where('teacher_id', $user->id)->delete();
        }


        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil mengubah data user.'
        ]);
    }

    public function delete(Request $request, User $users, ClassStudents $classStudent)
    {
        $validate = $request->validate([
            "user_id" => "required|exists:users,id",
        ], [
            "user.required" => "The user id is required.",
            "user.exist" => "The user id is not exists in users table.",
        ]);

        $user_id = $validate['user_id'];

        $user = $users->find($user_id);

        $user->delete();

        // success delete a users
        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil menghapus data users.'
        ]);
    }

    public function UserByAll(Request $request, User $users, Classes $classes)
    {
        $validate = $request->validate([
            'search' => 'string'
        ]);

        $search = $validate['search'];

        $classes = $classes->all();

        $users = $users->with(['studentClass', 'teacherClasses'])
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('role', 'like', "%{$search}%");
        })->paginate(10);

        // return list of searched user
        return view('dashboard.datauser', compact('users', 'classes'));
    }
}
