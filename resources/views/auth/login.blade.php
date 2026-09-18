<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 via-white to-gray-200 px-4 py-10">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden">

            <!-- ENCABEZADO -->
            <div class="bg-gradient-to-r from-[#720000] to-[#980000] px-8 py-8 text-center">
                <div class="flex justify-center">
                    <img src="{{ asset('images/psc-logo.png') }}" alt="PSC - Consultoría y Construcciones" class="w-full max-w-[380px] h-36 object-contain">
                </div>
                <h1 class="mt-4 text-3xl font-bold text-white">Bienvenido</h1>
                <p class="mt-2 text-sm text-red-100">Sistema de gestión de recursos y actividades</p>
            </div>

            <!-- FORMULARIO -->
            <div class="px-8 py-8">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4">
                        <p class="text-sm font-semibold text-red-700">Revisa los siguientes datos:</p>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- CORREO -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@psc.com"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 pl-10 pr-4 py-3 text-gray-800 placeholder-gray-400 shadow-sm focus:border-[#850000] focus:ring-2 focus:ring-red-200 focus:bg-white transition">
                        </div>
                    </div>

                    <!-- CONTRASEÑA -->
                    <div class="mt-5" x-data="{ verPassword: false }">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-7a2 2 0 00-2-2H6a2 2 0 00-2 2v7a2 2 0 002 2zm10-11V7a4 4 0 00-8 0v3h8z"/>
                                </svg>
                            </div>
                            <input :type="verPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 pl-10 pr-20 py-3 text-gray-800 placeholder-gray-400 shadow-sm focus:border-[#850000] focus:ring-2 focus:ring-red-200 focus:bg-white transition">
                            <button type="button" @click="verPassword = !verPassword" class="absolute inset-y-0 right-0 px-4 text-sm font-semibold text-[#850000] hover:text-[#5c0000] transition">
                                <span x-text="verPassword ? 'Ocultar' : 'Ver'"></span>
                            </button>
                        </div>
                    </div>

                    <!-- OPCIONES -->
                    <div class="flex items-center justify-between mt-5">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-[#850000] focus:ring-red-500">
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#850000] hover:text-[#5c0000] hover:underline transition">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <!-- BOTÓN -->
                    <button type="submit" class="w-full mt-7 rounded-lg bg-gradient-to-r from-[#720000] to-[#980000] hover:from-[#5c0000] hover:to-[#800000] active:scale-[0.98] py-3 text-white font-bold shadow-lg shadow-red-900/30 hover:shadow-xl transition-all duration-200">
                        Iniciar sesión
                    </button>
                </form>
            </div>

            <!-- PIE -->
            <div class="border-t border-gray-100 bg-gray-50 px-8 py-4 text-center">
                <p class="text-xs text-gray-500">© {{ date('Y') }} Consultoría y Construcciones PSC</p>
                <p class="text-xs text-gray-400 mt-1">Sistema de gestión de recursos y actividades</p>
            </div>

        </div>
    </div>
</x-guest-layout>