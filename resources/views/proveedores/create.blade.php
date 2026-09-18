<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Nuevo proveedor</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface shadow rounded-lg overflow-hidden">
                <div class="bg-primary px-6 py-3">
                    <h3 class="text-white font-semibold">Datos del proveedor</h3>
                </div>

                <form method="POST" action="{{ route('proveedores.store') }}" class="p-6">
                    @csrf

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Código de proveedor</label>
                    <input type="text" name="codigodp" value="{{ old('codigodp') }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>
                    @error('codigodp') <p class="text-danger text-sm mb-2">{{ $message }}</p> @enderror

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Nombre del proveedor</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Horarios de trabajo</label>
                            <input type="text" name="horarios_trabajo" value="{{ old('horarios_trabajo') }}"
                                class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Teléfono de contacto</label>
                            <input type="text" name="contacto_telefono" value="{{ old('contacto_telefono') }}"
                                class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3">
                        </div>
                    </div>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Correo de contacto</label>
                    <input type="email" name="contacto_email" value="{{ old('contacto_email') }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-4">

                    <div class="border-t border-surface-soft pt-4 mt-2">
                        <h4 class="font-semibold text-ink mb-3">Primer producto de este proveedor</h4>

                        <div class="grid grid-cols-4 gap-3">
                            <div class="col-span-2">
                                <label class="block mb-1 text-sm font-semibold text-ink-label">Nombre del producto</label>
                                <input type="text" name="nombre_producto" value="{{ old('nombre_producto') }}"
                                    class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-semibold text-ink-label">Unidad</label>
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
                                <label class="block mb-1 text-sm font-semibold text-ink-label">Precio</label>
                                <input type="number" step="0.01" name="precio_referencia" value="{{ old('precio_referencia') }}"
                                    class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                            </div>
                        </div>
                    </div>

                    @error('nombre_producto') <p class="text-danger text-sm mt-3">{{ $message }}</p> @enderror
                    @error('precio_referencia') <p class="text-danger text-sm mt-1">{{ $message }}</p> @enderror

                    <div class="mt-6 flex items-center gap-3">
                        <button type="submit"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                            Guardar proveedor y producto
                        </button>
                        <a href="{{ route('proveedores.index') }}" class="text-ink-muted hover:text-ink transition">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>