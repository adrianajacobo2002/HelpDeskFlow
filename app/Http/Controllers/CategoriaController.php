<?php

namespace App\Http\Controllers;
use App\Models\Categoria;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('id_categoria', 'asc')->paginate(10);
        return view('admin.categorias', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
        ]);

        Categoria::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id_categoria . ',id_categoria',
        ]);

        $categoria->nombre = $request->nombre;
        $categoria->save();

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->tickets()->exists()) {
            return redirect()->route('admin.categorias.index')
                            ->with('error', 'No se puede eliminar la categoría porque tiene tickets asignados.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
                        ->with('success', 'Categoría eliminada correctamente.');
    }

}
