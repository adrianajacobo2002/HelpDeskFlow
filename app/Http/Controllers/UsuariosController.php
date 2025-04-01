<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    // Mostrar todos los usuarios con filtros
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('tipo')) {
            if ($request->tipo === 'clientes') {
                $query->where('rol', 'cliente');
            } elseif ($request->tipo === 'empleados') {
                $query->whereIn('rol', ['admin', 'agente']);
            }
        }

        $usuarios = $query->orderBy('id', 'asc')->paginate(10);

        return view('admin.usuarios', compact('usuarios'));
    }

    // Crear nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'rol' => 'required|in:admin,agente,cliente',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'rol' => $request->rol,
                'password' => Hash::make($request->password),
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear usuario: ' . $e->getMessage()]);
        }        

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios-edit', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'rol' => 'required|in:admin,agente,cliente',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
