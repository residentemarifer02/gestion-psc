<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $validado = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol' => 'required|in:Gerente,Gerente General,Administrador',
        ]);

        User::create([
            'name' => $validado['name'],
            'email' => $validado['email'],
            'password' => Hash::make($validado['password']),
            'rol' => $validado['rol'],
        ]);

        return redirect()->route('usuarios.index')->with('status', 'Usuario creado correctamente.');
    }

    public function destroy(Request $request, User $usuario)
    {
        if ($usuario->id === $request->user()->id) {
            return back()->with('status', 'No puedes eliminar tu propio usuario.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('status', 'Usuario eliminado.');
    }
}