<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Models\product;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    function index(){
        $users = User::all();
        return view('users', ["users" => $users,
         'products'=>product::all(),
         'prices'=> Price::all()
         ]
        );
    }
    function create(Request $request){
       return view('create-user');
    }
//    do stuff about authentication
    function add_user(UserCreateRequest $request){
        $validated = $request->validated();
        $user = new User;
        $user->name = $validated['name'];
        $user->password = Hash::make($validated['password']);
        if($validated['su'] === 'on'){
            $user->su = true;
        }
        else {
            $user->su = false;
        }
        $user->save();
        return redirect()->action([UserController::class, "index"]);
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
        return redirect()->action([UserController::class, "index"]);
    }
    function delete(Request $request, User $user){
        $user->delete();
        return redirect('all-users');
    }
    function login(UserLoginRequest $request){
        $validated = $request->validated();
        $credentials = [
            "name" => $validated["username"],
            "password" => $validated["password"]
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }
    function show_login(){

        return view("auth-pages.login", ["page_title"=> "login"]);
    }
    function show_registration(){
        return view("auth-pages.register", ["page_title"=> "Register"]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->action([UserController::class, "show_login"]);
    }
}
