<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AuthController extends Controller
{

    /**
     * login
     */

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * logout
     */
    public function logout(Request $request): RedirectResponse
    {
        $guards = [
            'web', 'dashboard',
            'ko', 'kpp', 'audit', 'sap', 'csms', 'coe', 'kplh', 'mcu', 'pica', 'ibpr-and-bowtie', 'document-system', 'field-leadership'
        ];

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        // Do not invalidate session to keep 'admin' guard (Filament back-office) session alive.
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }



    /**
     * ganti  Password
     */

    public function changePassword(Request $request)
    {
        request()->validate(
            [
                'old_password' => 'required',
                'password' =>  'min:8', 'string',
                'password_confirmation' => 'required|same:password',
            ],
            []
        );

        $oldPassword = $request->old_password;
        $passwordNow =  Auth::user()->password;
        $newPassword = $request->password;
        if (Hash::check($oldPassword, $passwordNow) == false) //cek pasword lama
        {
            return response()->json(
                ["errors" => ["data" => ['old password is wrong']]],
                500
            );
        } else {
            $user = Auth::user();
            $user->password = Hash::make($newPassword);
            $user->update();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return [
                'status' => 'success',
                'message' => 'password has been changed'
            ];
        }
    }



    /**
     * forgot Password
     */

    //kirim link ke email
    public function forgotPassword(request $request)
    {
        $request->validate(['email' => 'required|email']);
        Password::sendResetLink(
            $request->only('email')
        );
        return redirect('/');
    }

    //form pasword baru
    public function formResetPassword(Request $request)
    {
        try {
            $name =  Crypt::decryptString($request->get('name'));
        } catch (DecryptException $e) {
            $name = null;
        }
        $token =  $request->token;
        return view('auth.passwords.reset', compact('token', 'name'));
    }

    //update password baru
    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|exists:users',
                'token' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ],
            []
        );

        $status = Password::reset(
            $request->only('name', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])
                    ->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['username' => [__($status)]]);
    }
}
