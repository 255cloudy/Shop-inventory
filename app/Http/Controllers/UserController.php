<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    function index(){
        $users = User::all();
        return view('users', ["users" => $users]);
    }
    function create(Request $request){
       return view('create-user');
    }
//    do stuff about authentication
    function add_user(Request $request){
        $validated = $request->validate([
            'name' => 'required|unique',
            'password' => 'required',
            'su' => 'required|boolean'
        ]);

        $user = new User;
        $user->name = $validated['name'];
        $user->password = Hash::make($validated['password']);
        $user->su = $validated['su'];
        $user->save();
        return redirect('all-users');
    }
    function update(Request $request, User $user){
        $validated = $request->validate([
            'name' => 'required',
            'password' => 'required',
            'su' => 'required|boolean'
        ]);
        $user->name = $validated['name'];
        $user->password = Hash::make($validated['password']);
        $user->su = $validated['su'];
        $user->save();
        return redirect('all-users');
    }
    function delete(Request $request, User $user){
        $user->delete();
        return redirect('all-users');
    }
}
