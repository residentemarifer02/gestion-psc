<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Proveedores</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-primary/10 border border-primary/30 text-primary rounded">{{ session('status') }}</div>
            @endif

            @auth
                @if (auth()->user()->esAdministrador())
                    <a href="{{ route('proveedores.create') }}"
                       class="inline-block mb-4 px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                        + Nuevo proveedor
                    </a>
                @endif
            @endauth

            <div class="bg-surface shadow rounded-lg divide-y divide-surface-soft overflow-hidden">
                @forelse ($proveedores as $proveedor)
                    <div class="p-4" x-data="{ verProductos: false, agregando: false }">
                        <div class="flex justify-between items-start gap-4">
                            <div>
                                <p class="font-semibold text-ink">
                                    <span class="text-xs text-primary font-mono">{{ $proveedor->codigodp }}</span>
                                    — {{ $proveedor->nombre }}
                                </p>
                                <p class="text-sm text-ink-muted">{{ $proveedor->direccion }}</p>
                                <p class="text-sm text-ink-muted">{{ $proveedor->contacto_telefono }} · {{ $proveedor->contacto_email }}</p>

                                <div class="flex items-center gap-4 mt-2">
                                    <button @click="verProductos = !verProductos" class="text-sm text-primary hover:text-primary-dark font-medium transition">
                                        <span x-text="verProductos ? 'Ocultar productos' : 'Ver productos (' + {{ $proveedor->productos->count() }} + ')'"></span>
                                    </button>

                                    @auth
                                        @if (auth()->user()->esAdministrador())
                                            <button @click="agregando = !agregando" class="text-sm text-primary hover:text-primary-dark font-medium transition">
                                                + Agregar producto
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </div>

                            <div class="flex items-center gap-3 shrink-0">
                                @auth
                                    @if (auth()->user()->esAdministrador())
                                        <a href="{{ route('proveedores.edit', $proveedor) }}"
                                           class="text-sm text-primary hover:text-primary-dark active:scale-95 font-medium transition">
                                            Editar
                                        </a>

                                        <form method="POST" action="{{ route('proveedores.destroy', $proveedor) }}"
                                              onsubmit="return confirm('¿Seguro que quieres eliminar este proveedor? Esto también borra sus productos y su historial de precios.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm text-danger hover:text-danger-dark active:scale-95 font-medium transition">Eliminar</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        <div x-show="agregando" x-cloak class="mt-3 bg-primary/5 border border-primary/20 rounded p-3">
                            <form method="POST" action="{{ route('proveedores.productos.store', $proveedor) }}" class="grid grid-cols-4 gap-2 items-end">
                                @csrf
                                <div class="col-span-2">
                                    <label class="block text-xs text-ink-label mb-1">Nombre del producto</label>
                                    <input type="text" name="nombre_producto" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary text-sm" required>
                                </div>
                                <div>
                                    <label class="block text-xs text-ink-label mb-1">Unidad</label>
                                    <select name="unidad" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary text-sm" required>
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
                                    <label class="block text-xs text-ink-label mb-1">Precio</label>
                                    <input type="number" step="0.01" name="precio_referencia" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary text-sm" required>
                                </div>
                                <div class="col-span-4">
                                    <button class="px-3 py-1.5 bg-primary hover:bg-primary-dark active:scale-95 text-white text-sm rounded font-semibold transition">
                                        Guardar producto
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div x-show="verProductos" x-cloak class="mt-3 bg-surface-soft/50 rounded p-3">
                            @forelse ($proveedor->productos as $producto)
                                <div class="flex justify-between text-sm py-1 border-b border-surface-soft last:border-0">
                                    <span class="text-ink">{{ $producto->nombre_producto }} <span class="text-ink-muted">({{ $producto->unidad }})</span></span>
                                    <span class="text-ink-muted">${{ number_format($producto->precio_referencia, 2) }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-ink-muted">Sin productos registrados.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-ink-muted">Aún no hay proveedores registrados.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>