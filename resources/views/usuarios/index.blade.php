<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Usuarios del sistema</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-primary/10 border border-primary/30 text-primary rounded">{{ session('status') }}</div>
            @endif

            <a href="{{ route('usuarios.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                + Nuevo usuario
            </a>

            <div class="bg-surface shadow rounded-lg divide-y divide-surface-soft overflow-hidden">
                @foreach ($usuarios as $usuario)
                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-ink">{{ $usuario->name }}</p>
                            <p class="text-sm text-ink-muted">{{ $usuario->email }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-primary/10 text-primary">
                                {{ $usuario->rol }}
                            </span>
                            @if ($usuario->id !== auth()->id())
                                <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                                      onsubmit="return confirm('¿Eliminar a {{ $usuario->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm text-danger hover:text-danger-dark active:scale-95 font-medium transition">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>