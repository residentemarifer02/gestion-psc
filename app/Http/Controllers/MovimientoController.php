<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Movimiento;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $query = Movimiento::with(['cliente', 'proveedor', 'usuario'])->orderByDesc('fecha')->orderByDesc('id');

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        $movimientos = $query->paginate(25)->withQueryString();

        $totalEntradas = (clone $query)->where('tipo', 'entrada')->sum('monto');
        $totalSalidas = (clone $query)->where('tipo', 'salida')->sum('monto');

        $clientes = Cliente::orderBy('nombre')->get();

        return view('movimientos.index', compact('movimientos', 'clientes', 'totalEntradas', 'totalSalidas'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $proveedores = Proveedor::where('activo', true)->orderBy('nombre')->get();

        return view('movimientos.create', compact('clientes', 'proveedores'));
    }

    public function store(Request $request)
    {
        $validado = $this->validarDatos($request);
        $validado['usuario_id'] = $request->user()->id;

        Movimiento::create($validado);

        return redirect()->route('movimientos.index')->with('status', 'Movimiento registrado correctamente.');
    }

    public function edit(Movimiento $movimiento)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $proveedores = Proveedor::orderBy('nombre')->get();

        return view('movimientos.edit', compact('movimiento', 'clientes', 'proveedores'));
    }

    public function update(Request $request, Movimiento $movimiento)
    {
        $validado = $this->validarDatos($request);

        $movimiento->update($validado);

        return redirect()->route('movimientos.index')->with('status', 'Movimiento actualizado correctamente.');
    }

    public function destroy(Movimiento $movimiento)
    {
        $movimiento->delete();

        return redirect()->route('movimientos.index')->with('status', 'Movimiento eliminado.');
    }

    private function validarDatos(Request $request): array
    {
        return $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'fecha' => 'required|date',
            'hora' => 'nullable',
            'tipo' => 'required|in:entrada,salida',
            'orden_compra' => 'nullable|string|max:100',
            'concepto' => 'required|string|max:255',
            'unidades' => 'nullable|numeric|min:0',
            'pago' => 'nullable|string|max:50',
            'unitario' => 'nullable|numeric|min:0',
            'cuenta' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'especifico' => 'nullable|string|max:255',
            'facturacion' => 'nullable|string|max:100',
            'empresa_facturacion' => 'nullable|string|max:255',
            'monto' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string',
        ]);
    }
}