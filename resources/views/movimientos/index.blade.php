<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Movimientos financieros</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-primary/10 border border-primary/30 text-primary rounded">{{ session('status') }}</div>
            @endif

            <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                <a href="{{ route('movimientos.create') }}"
                   class="px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                    + Registrar movimiento
                </a>

                <div class="flex gap-4 text-sm">
                    <span class="px-3 py-1.5 bg-primary/10 text-primary rounded font-semibold">
                        Entradas: ${{ number_format($totalEntradas, 2) }}
                    </span>
                    <span class="px-3 py-1.5 bg-danger/10 text-danger rounded font-semibold">
                        Salidas: ${{ number_format($totalSalidas, 2) }}
                    </span>
                </div>
            </div>

            <form method="GET" class="bg-surface shadow rounded-lg p-4 mb-4 grid grid-cols-4 gap-3 items-end">
                <div>
                    <label class="block text-xs text-ink-label mb-1">Cliente</label>
                    <select name="cliente_id" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary text-sm">
                        <option value="">Todos</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-ink-label mb-1">Tipo</label>
                    <select name="tipo" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary text-sm">
                        <option value="">Todos</option>
                        <option value="entrada" {{ request('tipo') === 'entrada' ? 'selected' : '' }}>Entrada</option>
                        <option value="salida" {{ request('tipo') === 'salida' ? 'selected' : '' }}>Salida</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-ink-label mb-1">Desde</label>
                    <input type="date" name="desde" value="{{ request('desde') }}" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary text-sm">
                </div>
                <div>
                    <label class="block text-xs text-ink-label mb-1">Hasta</label>
                    <input type="date" name="hasta" value="{{ request('hasta') }}" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary text-sm">
                </div>
                <div class="col-span-4">
                    <button class="px-3 py-1.5 bg-primary hover:bg-primary-dark active:scale-95 text-white text-sm rounded font-semibold transition">Filtrar</button>
                    <a href="{{ route('movimientos.index') }}" class="text-sm text-ink-muted hover:text-ink ml-2">Limpiar</a>
                </div>
            </form>

            <div class="bg-surface shadow rounded-lg overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-surface-soft text-ink-label text-left">
                        <tr>
                            <th class="p-3">Fecha</th>
                            <th class="p-3">Cliente</th>
                            <th class="p-3">Tipo</th>
                            <th class="p-3">Concepto</th>
                            <th class="p-3">Monto</th>
                            <th class="p-3">Usuario</th>
                            <th class="p-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-soft">
                        @forelse ($movimientos as $mov)
                            <tr class="hover:bg-surface-soft/50 transition">
                                <td class="p-3 text-ink">{{ $mov->fecha->format('d/m/Y') }}</td>
                                <td class="p-3 text-ink">{{ $mov->cliente->nombre }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $mov->tipo === 'entrada' ? 'bg-primary/10 text-primary' : 'bg-danger/10 text-danger' }}">
                                        {{ ucfirst($mov->tipo) }}
                                    </span>
                                </td>
                                <td class="p-3 text-ink">{{ $mov->concepto }}</td>
                                <td class="p-3 text-ink font-medium">${{ number_format($mov->monto, 2) }}</td>
                                <td class="p-3 text-ink-muted">{{ $mov->usuario->name }}</td>
                                <td class="p-3 text-right whitespace-nowrap">
                                    @auth
                                        @if (auth()->user()->esAdministrador())
                                            <a href="{{ route('movimientos.edit', $mov) }}" class="text-primary hover:text-primary-dark font-medium transition">Editar</a>
                                            <form method="POST" action="{{ route('movimientos.destroy', $mov) }}" class="inline"
                                                  onsubmit="return confirm('¿Eliminar este movimiento?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-danger hover:text-danger-dark font-medium ml-2 transition">Eliminar</button>
                                            </form>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="p-4 text-center text-ink-muted">No hay movimientos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $movimientos->links() }}</div>
        </div>
    </div>
</x-app-layout>