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
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">
                    Libros
                </h1>
                <p class="text-sm text-zinc-400 mt-0.5">
                    Gestiona el catálogo de libros del sistema
                </p>
            </div>
    </div>

    <div class="flex items-center gap-2">
        <button type="button"
            x-data @click="$dispatch('open-modal', { name: 'modal-importar-libros' })"
            class="flex items-center gap-2 px-4 py-2.5
                   bg-emerald-600 hover:bg-emerald-500
                   text-white font-semibold text-sm rounded-xl
                   shadow-lg hover:shadow-emerald-500/30
                   transition-all duration-200 hover:scale-105
                   border border-emerald-500/50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Importar
        </button>
        <a href="{{ route('libros.barcode.export') }}"
            class="flex items-center gap-2 px-4 py-2.5
                   bg-green-600 hover:bg-green-700
                   text-white font-semibold text-sm rounded-xl
                   shadow-lg hover:shadow-green-500/30
                   transition-all duration-200 hover:scale-105
                   border border-green-500/50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Códigos de Barras
        </a>
        <a href="{{ route('libros.create') }}" wire:navigate
            class="flex items-center gap-2 px-5 py-2.5
                   bg-indigo-600 hover:bg-indigo-500
                   text-white font-semibold text-sm rounded-xl
                   shadow-lg hover:shadow-indigo-500/30
                   transition-all duration-200 hover:scale-105
                   border border-indigo-500/50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Libro
        </a>
    </div>

    </div>
</div>
