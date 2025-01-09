<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classes;
use App\Models\ClassStudents;
use App\Rules\EnumStatus;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(User $users, Classes $classes) {
        $users = $users->paginate(15);
        $classes = $classes->all();

        return view('dashboard.datauser', ['users' => $users, 'classes' => $classes]);
    }

    public function insert(Request $request, User $users, Classes $classes, ClassStudents $classStudent) {
        $validate = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|password',
            'class_id' => 'exists:classes,id',
            'role' => 'required|string|in:admin,siswa,guru',
        ]);

        $user = $users->insert([
            'username' => $validate['username'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'role' => $validate['role']
        ]);


        if ($validate['class_id'] != '') {
            $classStudent->insert([
                'student_id' => $user->id,
                'class_id' => $validate['class_id']
            ]);
        }

        // success add new user and if the roles student also success set the student class
        // return view() 
    }

    public function update(int $user_id, Request $request, User $users, Classes $classes, ClassStudents $classStudent) {
        $validate = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|password',
            'class_id' => 'exists:classes,id',
            'role' => 'required|string|in:admin,siswa,guru',
        ]);

        $user = $users->find($user_id);

        $user->update([
            'username' => $validate['username'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'role' => $validate['role']
        ]);


        if ($validate['class_id'] != '') {
            $classStudent->patch([
                'student_id' => $user_id,
                'class_id' => $validate['class_id']
            ]);
        }

        // success add new user and if the roles student also success set the student class
        // return view() 
    }

    public function delete(int $user_id, User $users, ClassStudents $classStudent) {
        $user = $users->find($user_id);

        $user->delete();

        // success delete a users
        // return view();
    }

    public function UserByName(Request $request, User $users) {
        $validate = $request->validate([
            'search' => 'string'
        ]);

        $searchedUser = $users->where('username', 'like', '%' .$validate['search']. '%')->get();

        // return list of searched user
        // return view()
    }


}
 