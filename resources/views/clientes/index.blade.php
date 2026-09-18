<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Clientes</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-primary/10 border border-primary/30 text-primary rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-surface shadow rounded-lg overflow-hidden mb-6">
                <div class="bg-primary px-6 py-3">
                    <h3 class="text-white font-semibold">Agregar cliente</h3>
                </div>
                <form method="POST" action="{{ route('clientes.store') }}" class="p-6 grid grid-cols-3 gap-3 items-end">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm font-semibold text-ink-label">Código</label>
                        <input type="text" name="codigo" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-semibold text-ink-label">Nombre</label>
                        <input type="text" name="nombre" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary" required>
                    </div>
                    <button class="px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                        Agregar
                    </button>
                </form>
                @error('codigo') <p class="text-danger text-sm px-6 pb-4">{{ $message }}</p> @enderror
            </div>

            <div class="bg-surface shadow rounded-lg divide-y divide-surface-soft overflow-hidden">
                @forelse ($clientes as $cliente)
                    <div class="p-4 flex justify-between">
                        <span class="font-mono text-xs text-primary">{{ $cliente->codigo }}</span>
                        <span class="text-ink">{{ $cliente->nombre }}</span>
                    </div>
                @empty
                    <p class="p-4 text-ink-muted">Aún no hay clientes registrados.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>