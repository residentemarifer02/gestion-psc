<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-ink leading-tight">Nuevo usuario</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface shadow rounded-lg overflow-hidden">
                <div class="bg-primary px-6 py-3">
                    <h3 class="text-white font-semibold">Datos del nuevo usuario</h3>
                </div>

                <form method="POST" action="{{ route('usuarios.store') }}" class="p-6">
                    @csrf

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Rol</label>
                    <select name="rol" class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>
                        <option value="">Selecciona un rol...</option>
                        <option value="Gerente" {{ old('rol') === 'Gerente' ? 'selected' : '' }}>Gerente</option>
                        <option value="Gerente General" {{ old('rol') === 'Gerente General' ? 'selected' : '' }}>Gerente General</option>
                        <option value="Administrador" {{ old('rol') === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    </select>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Contraseña</label>
                    <input type="password" name="password"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-3" required>

                    <label class="block mb-1 text-sm font-semibold text-ink-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-md border-ink-muted/40 focus:border-primary focus:ring-primary mb-4" required>

                    @error('email') <p class="text-danger text-sm mb-2">{{ $message }}</p> @enderror
                    @error('password') <p class="text-danger text-sm mb-2">{{ $message }}</p> @enderror

                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark active:scale-95 text-white rounded font-semibold shadow-sm transition">
                            Crear usuario
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="text-ink-muted hover:text-ink">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>