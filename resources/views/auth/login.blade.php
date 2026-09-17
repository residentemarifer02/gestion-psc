<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-surface-soft px-4">
        <div class="w-full max-w-md bg-surface shadow-lg rounded-lg overflow-hidden">

            <div class="bg-primary px-8 py-6 text-center">
                <h1 class="text-xl font-bold text-white">Consultoría y Construcciones PSC</h1>
                <p class="text-white/80 text-sm mt-1">Sistema de gestión de recursos y actividades</p>
            </div>

            <div class="p-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded border border-danger/30 bg-danger/5">
                        <p class="text-sm text-danger font-medium">Revisa los siguientes datos:</p>
                        <ul class="mt-1 text-sm text-danger list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-ink-label mb-1">
                            Correo electrónico
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="block w-full rounded-md border-ink-muted/40 text-ink placeholder:text-ink-muted
                                   focus:border-primary focus:ring-primary shadow-sm">
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block text-sm font-semibold text-ink-label mb-1">
                            Contraseña
                        </label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full rounded-md border-ink-muted/40 text-ink placeholder:text-ink-muted
                                   focus:border-primary focus:ring-primary shadow-sm">
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-ink-muted/40 text-primary focus:ring-primary">
                            <span class="ms-2 text-sm text-ink-muted">Recordarme</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-primary hover:text-primary-dark underline" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="mt-6 w-full py-2.5 rounded-md bg-primary hover:bg-primary-dark text-white font-semibold
                               transition shadow-sm">
                        Ingresar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>