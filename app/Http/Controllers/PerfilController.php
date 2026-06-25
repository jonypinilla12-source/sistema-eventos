<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PerfilController extends Controller
{
    // Muestra la vista del perfil
    public function edit()
    {
        $usuario = auth()->user();
        return view('Perfil.Edit', compact('usuario'));
    }

    // Procesa el cambio de contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', // 'confirmed' obliga a que exista un campo 'password_confirmation' igual
        ], [
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $usuario = auth()->user();

        // 1. Verificamos que la contraseña actual ingresada sea correcta
        if (!Hash::check($request->current_password, $usuario->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'La contraseña actual es incorrecta.',
            ]);
        }

        // 2. Si es correcta, encriptamos y guardamos la nueva
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return back()->with('exito', '¡Tu contraseña ha sido actualizada con éxito!');
    }
}