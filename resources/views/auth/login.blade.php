<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4"
         style="background: linear-gradient(135deg, #1E3A5F 0%, #14283F 100%);">
        <div class="w-full max-w-md bg-surface shadow-2xl rounded-xl overflow-hidden">

            <div class="px-8 pt-8 pb-4 text-center border-b border-surface-soft">
                <img src="{{ asset('images/psc-logo.png') }}" alt="PSC" class="mx-auto h-24 w-auto object-contain">
                <p class="text-ink-muted text-sm mt-3">Sistema de gestión de recursos y actividades</p>
            </div>

            <div class="px-8 py-6 bg-surface-soft/40">
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

                    <div class="mt-4" x-data="{ verPassword: false }">
                        <label for="password" class="block text-sm font-semibold text-ink-label mb-1">
                            Contraseña
                        </label>
                        <div class="relative">
                            <input :type="verPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                                class="block w-full rounded-md border-ink-muted/40 text-ink placeholder:text-ink-muted
                                       focus:border-primary focus:ring-primary shadow-sm pr-16">
                            <button type="button" @click="verPassword = !verPassword"
                                class="absolute inset-y-0 right-0 px-3 text-sm text-primary hover:text-primary-dark">
                                <span x-text="verPassword ? 'Ocultar' : 'Ver'"></span>
                            </button>
                        </div>
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