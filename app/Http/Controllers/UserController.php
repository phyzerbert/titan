<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        config(['site.c_page' => 'users']);
        $data =  User::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.user', compact('data'));
    }

    public function create(Request $request){
        $request->validate([
            'name'=>'required|alpha_dash',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6|confirmed'
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return back()->with('success', 'Created successfully');
    }

    public function edit(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
        ]);
        $user = User::find($request->get('id'));
        $user->name = $request->get("name");
        $user->email = $request->get("email");

        if($request->get('password') != ''){
            $user->password = Hash::make($request->get('password'));
        }
        $user->update();
        return back()->with("success", "Updated User Successfully.");
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return back()->with("success", "Deleted Successfully!");
    }


}
