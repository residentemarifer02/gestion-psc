<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Registrar movimiento</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface shadow rounded-lg overflow-hidden">
                <div class="bg-primary px-6 py-3">
                    <h3 class="text-white font-semibold">Datos del movimiento</h3>
                </div>

                <form method="POST" action="{{ route('movimientos.store') }}" class="p-6">
                    @csrf

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Tipo</label>
                            <select name="tipo" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                                <option value="entrada">Entrada</option>
                                <option value="salida">Salida</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Cliente</label>
                            <select name="cliente_id" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                                <option value="">Selecciona...</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->codigo }} — {{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Fecha</label>
                            <input type="date" name="fecha" value="{{ now()->toDateString() }}"
                                class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Hora</label>
                            <input type="time" name="hora" value="{{ now()->format('H:i') }}"
                                class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                    </div>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Concepto</label>
                    <input type="text" name="concepto" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>

                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Orden de compra</label>
                            <input type="text" name="orden_compra" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Proveedor (si aplica)</label>
                            <select name="proveedor_id" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                                <option value="">— Ninguno —</option>
                                @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Método de pago</label>
                            <select name="pago" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                                <option value="">Selecciona...</option>
                                <option>Efectivo</option>
                                <option>Transferencia</option>
                                <option>Cheque</option>
                                <option>Tarjeta</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Unidades</label>
                            <input type="number" step="0.01" name="unidades" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Costo unitario</label>
                            <input type="number" step="0.01" name="unitario" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Monto total</label>
                            <input type="number" step="0.01" name="monto" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Cuenta</label>
                            <input type="text" name="cuenta" placeholder="Ej. PSC Banorte" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Específico</label>
                            <input type="text" name="especifico" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                    </div>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Descripción</label>
                    <input type="text" name="descripcion" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3">

                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Facturación</label>
                            <input type="text" name="facturacion" placeholder="Facturado / Pendiente / folio" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-semibold text-ink-label">Empresa de facturación</label>
                            <input type="text" name="empresa_facturacion" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary">
                        </div>
                    </div>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-4"></textarea>

                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded border border-danger/30 bg-danger/5 text-sm text-danger">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                            Guardar movimiento
                        </button>
                        <a href="{{ route('movimientos.index') }}" class="text-ink-muted hover:text-ink transition">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>