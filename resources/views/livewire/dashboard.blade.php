<div class="flex h-full w-full flex-1 flex-col gap-6">

    {{-- Header de bienvenida --}}
    <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div class="h-1 bg-gradient-to-r from-indigo-400 via-indigo-500 to-indigo-600"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/80 via-white to-zinc-50 dark:from-indigo-950/20 dark:via-zinc-900 dark:to-zinc-900 pointer-events-none"></div>
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-indigo-500/5 rounded-full pointer-events-none"></div>
        <div class="absolute -right-4 -bottom-8 w-32 h-32 bg-indigo-500/5 rounded-full pointer-events-none"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6 sm:p-8">
            <div class="flex items-center gap-5">
                <div class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center shadow-sm">
                    <svg class="w-9 h-9 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">LA SALLE</span>
                        <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                        <span class="text-xs text-zinc-400 dark:text-zinc-500">Sistema Biblioteca</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-white leading-tight">
                        Bienvenido,
                        <span class="bg-gradient-to-r from-indigo-500 to-indigo-600 bg-clip-text text-transparent">
                            {{ Auth::user()->name }}
                        </span>
                    </h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1.5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ ucfirst(\Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')) }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col items-start sm:items-end gap-2">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/40 rounded-full">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-400">Sistema activo</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Primera fila --}}
    <div class="grid gap-4 md:grid-cols-3">

        {{-- Estudiantes --}}
        <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent dark:from-sky-950/20 pointer-events-none"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-sky-100 dark:bg-sky-900/50 rounded-xl">
                        <svg class="w-6 h-6 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-sky-600 dark:text-sky-400 bg-sky-100 dark:bg-sky-900/50 px-2.5 py-1 rounded-full">Total</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ number_format($totalEstudiantes) }}</p>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Estudiantes registrados</p>
                <div class="mt-3 h-1 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-sky-400 to-sky-600 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>

        {{-- Libros --}}
        <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-50 to-transparent dark:from-violet-950/20 pointer-events-none"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-violet-100 dark:bg-violet-900/50 rounded-xl">
                        <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-violet-600 dark:text-violet-400 bg-violet-100 dark:bg-violet-900/50 px-2.5 py-1 rounded-full">Total</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ number_format($totalLibros) }}</p>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Libros en catálogo</p>
                <div class="mt-3 h-1 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-violet-400 to-violet-600 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>

        {{-- Préstamos hoy --}}
        <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-transparent dark:from-emerald-950/20 pointer-events-none"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/50 px-2.5 py-1 rounded-full">Hoy</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ number_format($prestamosHoy) }}</p>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Préstamos registrados hoy</p>
                <div class="mt-3 h-1 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-600 rounded-full"
                        style="width: {{ max(1, $prestamosHoy) }}%"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Segunda fila --}}
    <div class="grid gap-4 md:grid-cols-3">

        {{-- Préstamos activos --}}
        <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-transparent dark:from-blue-950/20 pointer-events-none"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-xl">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/50 px-2.5 py-1 rounded-full">Activos</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ number_format($prestamosActivos) }}</p>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Préstamos en curso</p>
                <div class="mt-3 h-1 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600 rounded-full"
                        style="width: {{ $totalPrestamos > 0 ? ($prestamosActivos / $totalPrestamos) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        {{-- Vencidos / Alerta --}}
        <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-transparent dark:from-red-950/20 pointer-events-none"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-red-100 dark:bg-red-900/50 rounded-xl">
                        <svg class="w-6 h-6 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-red-500 dark:text-red-400 bg-red-100 dark:bg-red-900/50 px-2.5 py-1 rounded-full">Alerta</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ number_format($prestamosVencidos) }}</p>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Devoluciones vencidas</p>
                <div class="mt-3 h-1 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-red-400 to-red-500 rounded-full"
                        style="width: {{ $prestamosActivos > 0 ? ($prestamosVencidos / $prestamosActivos) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        {{-- Total préstamos --}}
        <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-transparent dark:from-amber-950/20 pointer-events-none"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-amber-100 dark:bg-amber-900/50 rounded-xl">
                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/50 px-2.5 py-1 rounded-full">Historial</span>
                </div>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mb-1">{{ number_format($totalPrestamos) }}</p>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total préstamos realizados</p>
                <div class="mt-3 h-1 w-full bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-400 to-amber-600 rounded-full" style="width: 100%"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Libros más prestados --}}
    <div class="relative overflow-hidden bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50/50 to-transparent dark:from-indigo-950/10 pointer-events-none"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2.5 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Libros más prestados</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Top 5 libros con mayor demanda</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($librosMasPrestados as $item)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex-shrink-0">
                            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">{{ $loop->iteration }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $item['titulo'] }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            {{ $item['total'] }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Aún no hay préstamos registrados</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
