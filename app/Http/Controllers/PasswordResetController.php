<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;

class PasswordResetController extends Controller
{
    // 1. Muestra la vista donde el usuario escribe su correo
    public function request()
    {
        return view('auth.forgot-password');
    }

    // 2. Envía el correo con el enlace (Token)
    public function email(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => '¡Te hemos enviado un enlace para restablecer tu contraseña!'])
                    : back()->withErrors(['email' => 'No pudimos encontrar un usuario con ese correo electrónico.']);
    }

    // 3. Muestra la vista donde el usuario escribe la NUEVA contraseña (llega desde el correo)
    public function reset(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    // 4. Guarda la nueva contraseña en la base de datos
    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = \Illuminate\Support\Facades\Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Guarda la nueva clave
                $user->forceFill([
                    'password' => \Illuminate\Support\Facades\Hash::make($password)
                ])->save(); 

                event(new \Illuminate\Auth\Events\PasswordReset($user));

                // 👇 AQUÍ DISPARAMOS EL CORREO DE ÉXITO 👇
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\PasswordCambiadaMail($user));
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida! Ya puedes iniciar sesión.')
                    : back()->withErrors(['email' => 'El token es inválido o ha expirado.']);
    }
}