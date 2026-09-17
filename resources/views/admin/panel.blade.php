<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Panel de Administrador</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface shadow rounded-lg p-6">
                <p class="text-ink-muted">
                    Bienvenido, {{ auth()->user()->name }}. Este es el panel de administración.
                </p>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('proveedores.index') }}"
                       class="block p-4 rounded-lg border border-ink-muted/20 hover:border-primary hover:bg-surface-soft transition">
                        <h3 class="font-semibold text-ink">Proveedores</h3>
                        <p class="text-sm text-ink-muted mt-1">Ver y administrar proveedores y sus precios.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>