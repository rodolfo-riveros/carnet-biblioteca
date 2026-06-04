<div>
    {{-- Botón tipo sidebar item --}}
    <button wire:click="$dispatch('open-modal', { name: 'modal-notificaciones' })"
        class="flex items-center gap-3 w-full px-3 py-2.5 text-sm font-medium rounded-lg transition
               text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white"
        x-data @click="$dispatch('open-modal', { name: 'modal-notificaciones' })">
        <span class="relative">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if ($vencidosCount > 0)
                <span class="absolute -top-1.5 -right-1.5 flex items-center justify-center min-w-[16px] h-[16px] px-1 text-[9px] font-bold text-white bg-red-600 rounded-full">
                    {{ $vencidosCount > 99 ? '99+' : $vencidosCount }}
                </span>
            @endif
        </span>
        <span class="flex-1 text-left">Notificaciones</span>
        @if ($vencidosCount > 0)
            <span class="text-xs font-bold text-white bg-red-600 rounded-full px-2 py-0.5">{{ $vencidosCount }}</span>
        @endif
    </button>

    {{-- Modal --}}
    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-notificaciones') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-notificaciones') open = false"
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display:none">

        <div class="w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden flex flex-col"
            style="max-height: 85vh"
            @click.stop>

            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-gradient-to-r from-red-700 to-red-900">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">
                            {{ $vencidosCount > 0 ? "{$vencidosCount} préstamo(s) vencido(s)" : 'Notificaciones' }}
                        </h3>
                        <p class="text-xs text-red-200">Préstamos con fecha de devolución vencida</p>
                    </div>
                </div>
                <button @click="open = false"
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @forelse ($vencidos as $v)
                    <div class="p-4 rounded-xl border border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-900/10">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-bold text-zinc-900 dark:text-zinc-100">{{ $v['estudiante'] }}</p>
                                    <span class="text-xs font-bold text-red-600 dark:text-red-400 whitespace-nowrap">{{ $v['dias_vencido'] }} día(s)</span>
                                </div>
                                <p class="text-xs text-zinc-500">DNI: {{ $v['dni'] }}</p>
                                <p class="text-xs text-zinc-500 mt-0.5">Libro(s): {{ $v['libros'] }}</p>
                                <p class="text-xs text-zinc-500">Dev. prevista: {{ $v['fecha_prevista'] }}</p>
                                <div class="flex items-center gap-4 mt-2 pt-2 border-t border-red-200 dark:border-red-900">
                                    <a href="tel:{{ $v['celular'] }}"
                                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-green-700 dark:text-green-400 hover:text-green-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        {{ $v['celular'] }}
                                    </a>
                                    <span class="text-xs text-zinc-400">|</span>
                                    <span class="text-xs text-zinc-500">Préstamo #{{ $v['id'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-14 h-14 text-green-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-base font-semibold text-zinc-500 dark:text-zinc-400">Todos los préstamos están al día</p>
                        <p class="text-sm text-zinc-400 mt-1">No hay devoluciones vencidas</p>
                    </div>
                @endforelse
            </div>

            @if (count($vencidos) > 0)
                <div class="px-6 py-3 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 text-center">
                    <a href="{{ route('prestamos.index', ['filtroEstado' => 'vencido']) }}" wire:navigate @click="open = false"
                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700">
                        Ver todos los préstamos vencidos →
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
