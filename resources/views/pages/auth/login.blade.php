<x-layouts::auth :title="__('Iniciar Sesión')">
    <div class="flex flex-col gap-6">

        {{-- Logo y Bienvenida --}}
        <div class="flex flex-col items-center gap-3 mb-2">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-700 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div class="text-center">
                <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Biblioteca La Salle</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Sistema de Gestión Bibliotecaria</p>
            </div>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        {{-- Passkey (llave de acceso) --}}
        <x-passkey-verify
            :label="__('Iniciar con llave de acceso')"
            :loading-label="__('Autenticando...')"
            :separator="__('O continuar con correo')"
        />

        {{-- Formulario --}}
        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <flux:input
                name="email"
                label="Correo electrónico"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="admin@biblioteca.com"
                icon="envelope"
            />

            <div class="relative">
                <flux:input
                    name="password"
                    label="Contraseña"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Ingresa tu contraseña"
                    viewable
                    icon="lock-closed"
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </flux:link>
                @endif
            </div>

            <flux:checkbox name="remember" label="Recordar sesión" :checked="old('remember')" />

            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Iniciar Sesión
                </span>
            </flux:button>
        </form>

        <p class="text-xs text-center text-zinc-400 dark:text-zinc-500">
            © {{ date('Y') }} Biblioteca La Salle — Todos los derechos reservados
        </p>

    </div>
</x-layouts::auth>
