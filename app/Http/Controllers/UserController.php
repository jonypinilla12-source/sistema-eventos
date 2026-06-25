<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::with('rol')->get(); // Carga el usuario con su rol
        $roles = Role::all(); // Para el formulario de creación
        return view('Usuarios.Index', compact('usuarios', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:6',
            'rol_id' => 'required|exists:roles,rol_id'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'estado' => 1 // Activo por defecto
        ]);

        return redirect()->back()->with('exito', 'Usuario creado correctamente');
    }
}