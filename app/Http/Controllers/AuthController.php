<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create(){
        return inertia('Auth/Login');
    }

    public function store(LoginRequest $request){
        $data = $request->validated();
        if(!Auth::attempt($data, $request->remember)){
            throw ValidationException::withMessages([
                'email' => 'Authentication faild',
            ]);
        }
        $request->session()->regenerate();

        return redirect()->intended()->with('message', 'Autentificare cu succes!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function verifyEmail(){
        return inertia('Auth/VerifyEmail');
    }

    public function verificationEmail(EmailVerificationRequest $request){
        $request->fulfill();
 
        return redirect()->route('home');
    }

    public function resendVerifEmail(Request $request){
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }

    public function forgotPassword(){
        return inertia('Auth/ForgotPassword');
    }

    public function passwordEmail(Request $request){
        $request->validate(['email' => 'required|email']);
     
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['message' => __($status)])
                    : back()->withErrors(['email' => __($status)])
                    ->with(['status' => __($status)]);
    }

    public function passwordReset(string $token){
        return inertia('Auth/ResetPassword', [
            'token' => $token
        ]);
    }

    public function passwordUpdate(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('message', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
