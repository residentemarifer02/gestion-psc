<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar proveedor</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded p-6 mb-6">
            <form method="POST" action="{{ route('proveedores.update', $proveedor) }}">
                @csrf
                @method('PUT')

                <label class="block mb-2 font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" class="w-full border rounded p-2 mb-3" required>

                <label class="block mb-2 font-medium">Dirección</label>
                <input type="text" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}" class="w-full border rounded p-2 mb-3">

                <label class="block mb-2 font-medium">Horarios de trabajo</label>
                <input type="text" name="horarios_trabajo" value="{{ old('horarios_trabajo', $proveedor->horarios_trabajo) }}" class="w-full border rounded p-2 mb-3">

                <label class="block mb-2 font-medium">Teléfono de contacto</label>
                <input type="text" name="contacto_telefono" value="{{ old('contacto_telefono', $proveedor->contacto_telefono) }}" class="w-full border rounded p-2 mb-3">

                <label class="block mb-2 font-medium">Correo de contacto</label>
                <input type="email" name="contacto_email" value="{{ old('contacto_email', $proveedor->contacto_email) }}" class="w-full border rounded p-2 mb-4">

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar cambios</button>
                <a href="{{ route('proveedores.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </form>
        </div>

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded p-6 mb-6">
            <h3 class="font-semibold mb-3">Productos de este proveedor</h3>

            @foreach ($proveedor->productos as $producto)
                <div class="border-b py-3">
                    <div class="flex justify-between items-center">
                        <span class="font-medium">{{ $producto->nombre_producto }} — precio actual: ${{ number_format($producto->precio_referencia, 2) }}</span>
                        <form method="POST" action="{{ route('proveedores.productos.destroy', [$proveedor, $producto]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 text-sm">Eliminar producto</button>
                        </form>
                    </div>

                    <details class="mt-2">
                        <summary class="text-sm text-blue-600 cursor-pointer">Ver historial de precios ({{ $producto->historialPrecios->count() }})</summary>
                        <table class="w-full text-sm mt-2">
                            <thead>
                                <tr class="text-left text-gray-500">
                                    <th>Fecha</th>
                                    <th>Precio</th>
                                    <th>Capturado por</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($producto->historialPrecios as $registro)
                                    <tr class="border-t">
                                        <td>{{ $registro->fecha->format('d/m/Y') }}</td>
                                        <td>${{ number_format($registro->precio, 2) }}</td>
                                        <td>{{ $registro->capturadoPor->name ?? '—' }}</td>
                                        <td>{{ $registro->observaciones }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <form method="POST" action="{{ route('proveedores.productos.precios.store', [$proveedor, $producto]) }}" class="mt-3 flex gap-2 items-end">
                            @csrf
                            <div>
                                <label class="block text-xs text-gray-500">Nuevo precio</label>
                                <input type="number" step="0.01" name="precio" class="border rounded p-2 w-28" required>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500">Fecha</label>
                                <input type="date" name="fecha" class="border rounded p-2" value="{{ now()->toDateString() }}">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs text-gray-500">Observaciones</label>
                                <input type="text" name="observaciones" class="border rounded p-2 w-full">
                            </div>
                            <button class="px-3 py-2 bg-blue-600 text-white rounded text-sm">Registrar precio</button>
                        </form>
                    </details>
                </div>
            @endforeach

            <h4 class="font-medium mt-4 mb-2">Agregar nuevo producto</h4>
            <form method="POST" action="{{ route('proveedores.productos.store', $proveedor) }}" class="flex gap-2">
                @csrf
                <input type="text" name="nombre_producto" placeholder="Nombre del producto" class="border rounded p-2 flex-1" required>
                <input type="number" step="0.01" name="precio_referencia" placeholder="Precio inicial" class="border rounded p-2 w-32" required>
                <button class="px-3 py-2 bg-green-600 text-white rounded">Agregar</button>
            </form>
        </div>
    </div>
</x-app-layout>