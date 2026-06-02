<div class="relative overflow-hidden rounded-2xl
            bg-gradient-to-r from-zinc-800 via-zinc-900 to-indigo-950
            dark:from-zinc-900 dark:via-zinc-900 dark:to-indigo-950
            p-6 mb-6 shadow-xl border border-zinc-700 dark:border-transparent">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="absolute right-1/4 top-1/2 h-28 w-28 rounded-full bg-indigo-400/5 blur-2xl"></div>
    </div>

    <div class="relative z-10 flex items-center justify-between flex-wrap gap-4">

        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-14 h-14 rounded-2xl
                        bg-indigo-500/20
                        border border-indigo-400/30
                        shadow-lg backdrop-blur-md">
                <svg class="w-7 h-7 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">
                    Programas de Estudio
                </h1>
                <p class="text-sm text-zinc-400 mt-0.5">
                    Gestiona los programas de estudio del sistema
                </p>
            </div>
        </div>

        <a href="{{ route('programa-estudios.create') }}" wire:navigate
            class="flex items-center gap-2 px-5 py-2.5
                   bg-indigo-600 hover:bg-indigo-500
                   text-white font-semibold text-sm rounded-xl
                   shadow-lg hover:shadow-indigo-500/30
                   transition-all duration-200 hover:scale-105
                   border border-indigo-500/50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Programa
        </a>

    </div>
</div>
