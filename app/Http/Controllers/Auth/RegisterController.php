<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Concert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    public function register()
    {
        // ### 后面添加database 找出$code
        // request()->validate([
        //     'email' => 'required|email|unique:users',
        //     'password' => 'required'
        // ]);

        // $user = User::create([
        //     'email' => request('email'),
        //     'password' => bcrypt(request('password'))
        // ]);

        // $invitation->update(['user_id' => $user->id]);

        // auth()->login($user);

        // return redirect()->route('backstage.concerts.index');
        $concert = Concert::published()->findOrFail('1');
        return view('backstage.concerts.index', ['concert' => $concert]);
    }
}
