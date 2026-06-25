<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('Roles.Index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(['nombre_rol' => 'required|unique:roles|max:50']);
        Role::create($request->all());
        return redirect()->back()->with('exito', 'Rol creado');
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->back()->with('exito', 'Rol eliminado');
    }
}