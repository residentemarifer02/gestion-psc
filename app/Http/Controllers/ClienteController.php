<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->get();

        return view('clientes.index', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validado = $request->validate([
            'codigo' => 'required|string|max:50|unique:clientes,codigo',
            'nombre' => 'required|string|max:255',
        ]);

        Cliente::create($validado);

        return back()->with('status', 'Cliente agregado.');
    }
}