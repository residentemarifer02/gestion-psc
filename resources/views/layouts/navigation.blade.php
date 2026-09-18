<div x-data="{ open: false }">
    <!-- Botón hamburguesa solo en móvil -->
    <div class="sm:hidden flex items-center justify-between bg-primary px-4 py-3">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/psc-logo-circle.jpeg') }}" alt="PSC" class="h-10 w-10 rounded-full">
            <span class="text-white font-semibold">PSC</span>
        </div>
        <button @click="open = ! open" class="text-white p-2">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': !open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <aside
        :class="open ? 'block' : 'hidden'"
        class="sm:block w-full sm:w-64 sm:min-h-screen bg-primary flex-shrink-0">

        <div class="hidden sm:flex flex-col items-center py-8 border-b border-white/10">
            <img src="{{ asset('images/psc-logo-circle.jpeg') }}" alt="PSC" class="h-28 w-28 rounded-full shadow-lg">
            <span class="text-white font-semibold mt-3 text-center px-4">Consultoría y Construcciones PSC</span>
        </div>

        <nav class="py-4 px-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-2.5 rounded-md text-sm font-medium text-white transition
                      {{ request()->routeIs('dashboard') || request()->routeIs('*.panel') ? 'bg-primary-dark' : 'hover:bg-primary-dark' }}">
                Inicio
            </a>

            <a href="{{ route('proveedores.index') }}"
               class="block px-4 py-2.5 rounded-md text-sm font-medium text-white transition
                      {{ request()->routeIs('proveedores.*') ? 'bg-primary-dark' : 'hover:bg-primary-dark' }}">
                Proveedores
            </a>

            <a href="{{ route('clientes.index') }}"
               class="block px-4 py-2.5 rounded-md text-sm font-medium text-white transition
                      {{ request()->routeIs('clientes.*') ? 'bg-primary-dark' : 'hover:bg-primary-dark' }}">
                Clientes
            </a>

            <a href="{{ route('movimientos.index') }}"
               class="block px-4 py-2.5 rounded-md text-sm font-medium text-white transition
                      {{ request()->routeIs('movimientos.*') ? 'bg-primary-dark' : 'hover:bg-primary-dark' }}">
                Movimientos
            </a>

            @auth
                @if (auth()->user()->esAdministrador())
                    <a href="{{ route('usuarios.index') }}"
                       class="block px-4 py-2.5 rounded-md text-sm font-medium text-white transition
                              {{ request()->routeIs('usuarios.*') ? 'bg-primary-dark' : 'hover:bg-primary-dark' }}">
                        Usuarios
                    </a>
                @endif
            @endauth

            <div class="border-t border-white/10 my-3"></div>

            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2.5 rounded-md text-sm font-medium text-white transition
                      {{ request()->routeIs('profile.*') ? 'bg-primary-dark' : 'hover:bg-primary-dark' }}">
                Mi perfil
            </a>

            <div class="px-4 py-2 text-white/70 text-xs">
                {{ Auth::user()->name }} · {{ Auth::user()->rol }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2.5 rounded-md text-sm font-medium text-white hover:bg-primary-dark transition">
                    Cerrar sesión
                </button>
            </form>
        </nav>
    </aside>
</div>