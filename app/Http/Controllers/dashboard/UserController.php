<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\ClassStudents;
use App\Rules\EnumStatus;
use App\EnumRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(User $users, Classes $classes)
    {
        $users = $users->with('class')->paginate(15);
        $classes = $classes->all();

        return view('dashboard.datauser', compact('users', 'classes'));
    }

    public function insert(Request $request, User $users, ClassStudents $classStudent)
    {
        // validasi input
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'role' => ['required', 'string', Rule::enum(EnumRole::class)],
            'class' => ['required_if:role,Siswa', 'exists:classes,id'],
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
            'class.required_if' => 'The class field is required when the role is Siswa.',
            'class.exists' => 'The selected class does not exist.',
        ]);
        // buat data user baru
        $user = $users->create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'role' => $validate['role']
        ]);

        // jika user merupaka siswa maka menetapkan data kelas untuk user
        if ($validate['role'] == EnumRole::Siswa) {
            $classStudent->create([
                'student_id' => $user->id,
                'class_id' => $validate['class']
            ]);
        }

        // kembali ke halaman user
        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil menambahkan user baru.'
        ]);
    }

    public function update(Request $request, User $users, Classes $classes, ClassStudents $classStudent)
    {
        // set password input menjadi string ''
        $request->merge([
            'password' => $request->password ?? '',
        ]);
        // validasi input

        $validate = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'string',
            'role' => ['required', 'string', Rule::enum(EnumRole::class)],
            'class' => ['required_if:role,siswa', 'exists:classes,id'],
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
            'class.required_if' => 'The class field is required when the role is Siswa.',
            'class.exists' => 'The selected class does not exist.',
        ]);        

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

        $studentClass = $classStudent->where('student_id', $user->id);
        
        // jika user berganti menjadi siswa
        if ($user->role === 'siswa') {
            $classId = $validate['class'];
            $data = ['student_id' => $user->id, 'class_id' => $classId];
            // jika user merupakan siswa dan sudah di tetapkan kelasnya, maka kelasnya akan diubah dan jika belum maka tetapkan kelasnya
            empty($studentClass) ? $studentClass->update($data) : $classStudent->create($data);
        } else {
            // jika user berubah menjadi selain siswa maka data kelasnya akan dihapus
            $studentClass?->delete();
        }


        return redirect()->back()->with([
            'status' => true,
            'msg' => 'Berhasil mengubah data user.'
        ]);
    }

    public function delete(int $user_id, User $users, ClassStudents $classStudent)
    {
        $user = $users->find($user_id);

        $user->delete();

        // success delete a users
        // return view();
    }

    public function UserByName(Request $request, User $users)
    {
        $validate = $request->validate([
            'search' => 'string'
        ]);

        $searchedUser = $users->where('username', 'like', '%' . $validate['search'] . '%')->get();

        // return list of searched user
        // return view()
    }
}
