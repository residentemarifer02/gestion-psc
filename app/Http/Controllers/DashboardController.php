<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $usuario = $request->user();

        if ($usuario->esAdministrador()) {
            return redirect()->route('admin.panel');
        }

        if ($usuario->esGerenteGeneral()) {
            return redirect()->route('gerencia.panel');
        }

        return redirect()->route('gerente.panel');
    }
}