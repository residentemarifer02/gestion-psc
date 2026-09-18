<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Editar proveedor</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 mb-6">
            <div class="bg-surface shadow rounded-lg overflow-hidden">
                <div class="bg-primary px-6 py-3">
                    <h3 class="text-white font-semibold">Datos del proveedor</h3>
                </div>

                <form method="POST" action="{{ route('proveedores.update', $proveedor) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Código de proveedor</label>
                    <input type="text" name="codigodp" value="{{ old('codigodp', $proveedor->codigodp) }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>
                    @error('codigodp') <p class="text-danger text-sm mb-2">{{ $message }}</p> @enderror

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Horarios de trabajo</label>
                            <input type="text" name="horarios_trabajo" value="{{ old('horarios_trabajo', $proveedor->horarios_trabajo) }}"
                                class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Teléfono de contacto</label>
                            <input type="text" name="contacto_telefono" value="{{ old('contacto_telefono', $proveedor->contacto_telefono) }}"
                                class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3">
                        </div>
                    </div>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Correo de contacto</label>
                    <input type="email" name="contacto_email" value="{{ old('contacto_email', $proveedor->contacto_email) }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-4">

                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                        Guardar cambios
                    </button>
                    <a href="{{ route('proveedores.index') }}" class="ml-2 text-ink-muted hover:text-ink transition">Cancelar</a>
                </form>
            </div>
        </div>

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface shadow rounded-lg overflow-hidden">
                <div class="bg-primary px-6 py-3">
                    <h3 class="text-white font-semibold">Productos de este proveedor</h3>
                </div>

                <div class="p-6">
                    @if (session('status'))
                        <div class="mb-4 p-3 bg-primary/10 border border-primary/30 text-primary rounded text-sm">{{ session('status') }}</div>
                    @endif

                    @foreach ($proveedor->productos as $producto)
                        <div class="border-b border-surface-soft py-3 last:border-0">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-ink">
                                    {{ $producto->nombre_producto }}
                                    <span class="text-ink-muted text-sm">({{ $producto->unidad }})</span>
                                    — precio actual: ${{ number_format($producto->precio_referencia, 2) }}
                                </span>
                                <form method="POST" action="{{ route('proveedores.productos.destroy', [$proveedor, $producto]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-danger hover:text-danger-dark text-sm font-medium transition">Eliminar producto</button>
                                </form>
                            </div>

                            <details class="mt-2">
                                <summary class="text-sm text-primary hover:text-primary-dark cursor-pointer transition">
                                    Ver historial de precios ({{ $producto->historialPrecios->count() }})
                                </summary>
                                <table class="w-full text-sm mt-2">
                                    <thead>
                                        <tr class="text-left text-ink-muted">
                                            <th>Fecha</th>
                                            <th>Precio</th>
                                            <th>Capturado por</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($producto->historialPrecios as $registro)
                                            <tr class="border-t border-surface-soft">
                                                <td class="text-ink">{{ $registro->fecha->format('d/m/Y') }}</td>
                                                <td class="text-ink">${{ number_format($registro->precio, 2) }}</td>
                                                <td class="text-ink-muted">{{ $registro->capturadoPor->name ?? '—' }}</td>
                                                <td class="text-ink-muted">{{ $registro->observaciones }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <form method="POST" action="{{ route('proveedores.productos.precios.store', [$proveedor, $producto]) }}" class="mt-3 flex gap-2 items-end">
                                    @csrf
                                    <div>
                                        <label class="block text-xs text-ink-label">Nuevo precio</label>
                                        <input type="number" step="0.01" name="precio" class="rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary w-28" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs text-ink-label">Fecha</label>
                                        <input type="date" name="fecha" class="rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" value="{{ now()->toDateString() }}">
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs text-ink-label">Observaciones</label>
                                        <input type="text" name="observaciones" class="rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary w-full">
                                    </div>
                                    <button class="px-3 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded text-sm font-semibold transition">
                                        Registrar precio
                                    </button>
                                </form>
                            </details>
                        </div>
                    @endforeach

                    <h4 class="font-semibold text-ink mt-4 mb-2">Agregar nuevo producto</h4>
                    <form method="POST" action="{{ route('proveedores.productos.store', $proveedor) }}" class="grid grid-cols-4 gap-2 items-end">
                        @csrf
                        <div class="col-span-2">
                            <label class="block text-xs text-ink-label mb-1">Nombre del producto</label>
                            <input type="text" name="nombre_producto" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                        </div>
                        <div>
                            <label class="block text-xs text-ink-label mb-1">Unidad</label>
                            <select name="unidad" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                                <option value="pieza">Pieza</option>
                                <option value="kg">Kilogramo</option>
                                <option value="tonelada">Tonelada</option>
                                <option value="litro">Litro</option>
                                <option value="metro">Metro</option>
                                <option value="metro2">Metro²</option>
                                <option value="caja">Caja</option>
                                <option value="rollo">Rollo</option>
                                <option value="servicio">Servicio</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-ink-label mb-1">Precio inicial</label>
                            <input type="number" step="0.01" name="precio_referencia" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                        </div>
                        <div class="col-span-4">
                            <button class="px-3 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded text-sm font-semibold transition">
                                Agregar producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>