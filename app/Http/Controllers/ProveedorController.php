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
        $proveedores = Proveedor::with('productos.historialPrecios')->orderBy('nombre')->get();

        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $validado = $request->validate([
            'codigodp' => 'required|string|max:50|unique:proveedores,codigodp',
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'horarios_trabajo' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:50',
            'contacto_email' => 'nullable|email|max:255',
            'nombre_producto' => 'required|string|max:255',
            'unidad' => 'required|string|max:50',
            'precio_referencia' => 'required|numeric|min:0',
        ]);

        $proveedor = Proveedor::create([
            'codigodp' => $validado['codigodp'],
            'nombre' => $validado['nombre'],
            'direccion' => $validado['direccion'] ?? null,
            'horarios_trabajo' => $validado['horarios_trabajo'] ?? null,
            'contacto_telefono' => $validado['contacto_telefono'] ?? null,
            'contacto_email' => $validado['contacto_email'] ?? null,
        ]);

        $producto = $proveedor->productos()->create([
            'nombre_producto' => $validado['nombre_producto'],
            'unidad' => $validado['unidad'],
            'precio_referencia' => $validado['precio_referencia'],
        ]);

        HistorialPrecioProducto::create([
            'proveedor_producto_id' => $producto->id,
            'precio' => $validado['precio_referencia'],
            'fecha' => now()->toDateString(),
            'capturado_por' => $request->user()->id,
        ]);

        return redirect()->route('proveedores.index')->with('status', 'Proveedor y producto registrados correctamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        $proveedor->load('productos.historialPrecios');

        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $validado = $request->validate([
            'codigodp' => 'required|string|max:50|unique:proveedores,codigodp,' . $proveedor->id,
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
        // TODO: cuando exista el módulo de Órdenes/Movimientos, validar aquí que este
        // proveedor no esté referenciado en ningún movimiento antes de permitir borrarlo.
        // Por ahora ese módulo no existe, así que no hay nada que lo detenga.

        $proveedor->delete(); // borra en cascada sus productos e historial de precios

        return redirect()->route('proveedores.index')->with('status', 'Proveedor eliminado.');
    }

    public function agregarProducto(Request $request, Proveedor $proveedor)
    {
        $validado = $request->validate([
            'nombre_producto' => 'required|string|max:255',
            'unidad' => 'required|string|max:50',
            'precio_referencia' => 'required|numeric|min:0',
            'fecha' => 'nullable|date',
        ]);

        $producto = $proveedor->productos()->create([
            'nombre_producto' => $validado['nombre_producto'],
            'unidad' => $validado['unidad'],
            'precio_referencia' => $validado['precio_referencia'],
        ]);

        HistorialPrecioProducto::create([
            'proveedor_producto_id' => $producto->id,
            'precio' => $validado['precio_referencia'],
            'fecha' => $validado['fecha'] ?? now()->toDateString(),
            'capturado_por' => $request->user()->id,
        ]);

        return back()->with('status', 'Producto agregado.');
    }

    public function eliminarProducto(Proveedor $proveedor, ProveedorProducto $producto)
    {
        if ($producto->historialPrecios()->count() > 1) {
            return back()->with('status', 'No se eliminó: este producto ya tiene historial de precios registrado.');
        }

        $producto->delete();

        return back()->with('status', 'Producto eliminado.');
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
            'capturado_por' => $request->user()->id,
            'observaciones' => $validado['observaciones'] ?? null,
        ]);

        $masReciente = $producto->historialPrecios()->first();
        if ($masReciente && $masReciente->fecha->toDateString() === $fecha) {
            $producto->update(['precio_referencia' => $validado['precio']]);
        }

        return redirect()->route('proveedores.edit', $proveedor)->with('status', 'Precio registrado en el historial.');
    }
}