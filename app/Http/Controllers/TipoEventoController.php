<?php

namespace App\Http\Controllers;

use App\Models\TipoEvento;
use Illuminate\Http\Request;

class TipoEventoController extends Controller
{
    public function index()
    {
        $tipos = TipoEvento::all();
        return view('TipoEventos.Index', compact('tipos'));
    }

    // 1. Mostrar formulario de creación
    public function create()
    {
        return view('TipoEventos.Create');
    }

    // 2. Guardar el nuevo tipo en la DB
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:tipos_evento,nombre|max:50'
        ]);

        TipoEvento::create($request->all());
        return redirect()->route('tipos.index')->with('exito', 'Tipo de evento creado correctamente.');
    }

    // 3. Mostrar formulario de edición
    public function edit($id)
    {
        $tipo = TipoEvento::findOrFail($id);
        return view('TipoEventos.Edit', compact('tipo'));
    }

    // 4. Actualizar los datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:50|unique:tipos_evento,nombre,' . $id . ',tipo_evento_id'
        ]);

        $tipo = TipoEvento::findOrFail($id);
        $tipo->update($request->all());

        return redirect()->route('tipos.index')->with('exito', 'Tipo de evento actualizado.');
    }

    // 5. Eliminar
    public function destroy($id)
    {
        $tipo = TipoEvento::findOrFail($id);
        $tipo->delete();
        return redirect()->route('tipos.index')->with('exito', 'Tipo de evento eliminado.');
    }
}
