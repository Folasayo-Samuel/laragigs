<?php

namespace App\Http\Controllers;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
	// Show Register/Create Form
	public function create(){
	 return view('users.register');
	}

	// Create New User
	public function store(Request $request){
		$formFields = $request->validate([
			'name' => ['required', 'min:3'],
			'email' => ['required', 'email', Rule::unique('users', 'email')],
			'password' => 'required|min:6|confirmed'
		]);

		//  Hash Password
		$formFields['password'] = bcrypt($formFields['password']);

		// Create New User
		$user = User::create($formFields);

		// Authenticate User
		auth('web')->login($user);

		return redirect('/')->with('message', 'User created and logged in successfully');
	}

	// Logout User
	public function logout(Request $request){
	 auth('web')->logout();

	 $request->session()->invalidate();
	 $request->session()->regenerateToken();

	 return redirect('/')->with('message', 'User logged out successfully');
	}

	public function login(){
	return view('users.login');
	}

	// Authenticate User
	public function authenticate(Request $request){
		$formFields = $request->validate([
			'email' => ['required', 'email'],
			'password' => 'required'
		]);

		if(auth('web')->attempt($formFields)){
		 $request->session()->regenerateToken();

		 return redirect('/')->with('message', 'You are now logged in!');
		}

		return back()->withErrors(['email' => "Invalid email"])->onlyInput('email');
	}
}
