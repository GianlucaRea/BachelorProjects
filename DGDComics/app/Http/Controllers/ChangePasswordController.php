<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        if(Auth::user()) {
            $request->validate([
                'password' => ['required', 'min:8', new MatchOldPassword],
                'newPassword' => ['required', 'min:8', 'different:password'],
                'confirmPassword' => ['same:newPassword'],
            ]);

            User::find(auth()->user()->id)->update(['password' => Hash::make($request->newPassword)]);

            $user = \Illuminate\Support\Facades\Auth::user();
            return redirect('/accountArea/account')
                ->with(compact('user'));
        }
        else{
            return redirect('/login');
        }
    }
}