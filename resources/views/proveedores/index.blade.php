<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Proveedores</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            @auth
                @if (auth()->user()->esAdministrador())
                    <a href="{{ route('proveedores.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                        + Nuevo proveedor
                    </a>
                @endif
            @endauth

            <div class="bg-white shadow rounded divide-y">
                @forelse ($proveedores as $proveedor)
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold">{{ $proveedor->nombre }}</p>
                                <p class="text-sm text-gray-600">{{ $proveedor->direccion }}</p>
                                <p class="text-sm text-gray-600">{{ $proveedor->contacto_telefono }} · {{ $proveedor->contacto_email }}</p>
                                <p class="text-sm text-gray-500">{{ $proveedor->productos->count() }} producto(s) registrado(s)</p>
                            </div>
                            @auth
                                @if (auth()->user()->esAdministrador())
                                    <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-blue-600">Editar</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <p class="p-4 text-gray-500">Aún no hay proveedores registrados.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>