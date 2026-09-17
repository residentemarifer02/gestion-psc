<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo proveedor</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-white shadow rounded p-6">
            <form method="POST" action="{{ route('proveedores.store') }}">
                @csrf

                <label class="block mb-2 font-medium">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border rounded p-2 mb-3" required>

                <label class="block mb-2 font-medium">Dirección</label>
                <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full border rounded p-2 mb-3">

                <label class="block mb-2 font-medium">Horarios de trabajo</label>
                <input type="text" name="horarios_trabajo" value="{{ old('horarios_trabajo') }}" class="w-full border rounded p-2 mb-3">

                <label class="block mb-2 font-medium">Teléfono de contacto</label>
                <input type="text" name="contacto_telefono" value="{{ old('contacto_telefono') }}" class="w-full border rounded p-2 mb-3">

                <label class="block mb-2 font-medium">Correo de contacto</label>
                <input type="email" name="contacto_email" value="{{ old('contacto_email') }}" class="w-full border rounded p-2 mb-4">

                @error('nombre') <p class="text-red-600 text-sm mb-2">{{ $message }}</p> @enderror

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
                <a href="{{ route('proveedores.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </form>
        </div>
    </div>
</x-app-layout>