<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create(){
        return inertia('Auth/Register');
    }

    public function store(RegisterRequest $request){
        $data = $request->validated();
        $user = User::create($data);
        Auth::login($user);

        event(new Registered($user));

        return redirect()->route('home')->with('message', 'Inregistrare efectuata cu succes');
    }
}
