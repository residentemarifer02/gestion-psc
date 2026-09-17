<?php

namespace App\Http\Controllers;

use App\Models\HistorialPrecioProducto;
use App\Models\Proveedor;
use App\Models\ProveedorProducto;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::with('productos')->orderBy('nombre')->get();

        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $validado = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'horarios_trabajo' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:50',
            'contacto_email' => 'nullable|email|max:255',
        ]);

        Proveedor::create($validado);

        return redirect()->route('proveedores.index')->with('status', 'Proveedor creado correctamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        $proveedor->load('productos.historialPrecios');

        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $validado = $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'horarios_trabajo' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:50',
            'contacto_email' => 'nullable|email|max:255',
        ]);

        $proveedor->update($validado);

        return redirect()->route('proveedores.index')->with('status', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('status', 'Proveedor eliminado.');
    }

    public function agregarProducto(Request $request, Proveedor $proveedor)
    {
        $validado = $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'precio_referencia' => 'required|numeric|min:0',
            'fecha' => 'nullable|date',
        ]);

        $producto = $proveedor->productos()->create([
            'nombre_producto' => $validado['nombre_producto'],
            'precio_referencia' => $validado['precio_referencia'],
        ]);

        // el primer precio también entra al historial
        HistorialPrecioProducto::create([
            'proveedor_producto_id' => $producto->id,
            'precio' => $validado['precio_referencia'],
            'fecha' => $validado['fecha'] ?? now()->toDateString(),
            'capturado_por' => auth()->id(),
        ]);

        return redirect()->route('proveedores.edit', $proveedor)->with('status', 'Producto agregado.');
    }

    public function eliminarProducto(Proveedor $proveedor, ProveedorProducto $producto)
    {
        $producto->delete();

        return redirect()->route('proveedores.edit', $proveedor)->with('status', 'Producto eliminado.');
    }

    public function registrarNuevoPrecio(Request $request, Proveedor $proveedor, ProveedorProducto $producto)
    {
        $validado = $request->validate([
            'precio' => 'required|numeric|min:0',
            'fecha' => 'nullable|date',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $fecha = $validado['fecha'] ?? now()->toDateString();

        HistorialPrecioProducto::create([
            'proveedor_producto_id' => $producto->id,
            'precio' => $validado['precio'],
            'fecha' => $fecha,
            'capturado_por' => auth()->id(),
            'observaciones' => $validado['observaciones'] ?? null,
        ]);

        // actualiza el precio "actual" solo si la fecha nueva es la más reciente
        $masReciente = $producto->historialPrecios()->first();
        if ($masReciente && $masReciente->fecha->toDateString() === $fecha) {
            $producto->update(['precio_referencia' => $validado['precio']]);
        }

        return redirect()->route('proveedores.edit', $proveedor)->with('status', 'Precio registrado en el historial.');
    }
}