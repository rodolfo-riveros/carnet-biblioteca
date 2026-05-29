<div class="relative overflow-hidden rounded-2xl
            bg-gradient-to-r from-zinc-800 via-zinc-900 to-indigo-950
            dark:from-zinc-900 dark:via-zinc-900 dark:to-indigo-950
            p-6 mb-6 shadow-xl border border-zinc-700 dark:border-transparent">

    {{-- Fondo decorativo --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute right-1/4 top-1/2 h-28 w-28 rounded-full bg-indigo-400/5 blur-2xl"></div>
    </div>

    <div class="relative z-10 flex items-center justify-between flex-wrap gap-4">

        {{-- Ícono + Título --}}
        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-14 h-14 rounded-2xl
                        bg-indigo-500/20
                        border border-indigo-400/30
                        shadow-lg backdrop-blur-md">
                <svg class="w-7 h-7 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5
                           M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">
                    Instituciones
                </h1>
                <p class="text-sm text-zinc-400 mt-0.5">
                    Gestiona las instituciones del sistema
                </p>
            </div>
        </div>

        {{-- Botón nueva institución --}}
        <a href="{{ route('instituciones.create') }}" wire:navigate
            class="flex items-center gap-2 px-5 py-2.5
                   bg-indigo-600 hover:bg-indigo-500
                   text-white font-semibold text-sm rounded-xl
                   shadow-lg hover:shadow-indigo-500/30
                   transition-all duration-200 hover:scale-105
                   border border-indigo-500/50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Institución
        </a>

    </div>
</div>
