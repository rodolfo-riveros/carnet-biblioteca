<div class="w-full bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden p-4">
    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
        <h3 class="text-sm font-bold text-zinc-700 dark:text-zinc-200">
            Ejemplares con Código de Barras
        </h3>
        <div class="flex items-center gap-2 flex-wrap">
            <select wire:model.live="perPage"
                class="px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 rounded-lg text-xs dark:bg-zinc-800 dark:text-white">
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar..."
                    class="pl-8 pr-3 py-1.5 border border-zinc-300 dark:border-zinc-600 rounded-lg text-xs w-48 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500" />
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-xs border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 dark:bg-zinc-800">
                <tr>
                    <th class="px-3 py-2.5 text-left font-semibold text-zinc-700 dark:text-zinc-200">#</th>
                    <th class="px-3 py-2.5 text-left font-semibold text-zinc-700 dark:text-zinc-200">Libro</th>
                    <th class="px-3 py-2.5 text-left font-semibold text-zinc-700 dark:text-zinc-200">Código Barras</th>
                    <th class="px-3 py-2.5 text-center font-semibold text-zinc-700 dark:text-zinc-200">Copia</th>
                    <th class="px-3 py-2.5 text-center font-semibold text-zinc-700 dark:text-zinc-200">Estado</th>
                    <th class="px-3 py-2.5 text-center font-semibold text-zinc-700 dark:text-zinc-200">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($ejemplares as $ejemplar)
                    <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition">
                        <td class="px-3 py-2.5 font-medium text-zinc-500 dark:text-zinc-400">{{ $ejemplar->id }}</td>
                        <td class="px-3 py-2.5 max-w-[200px]">
                            <p class="font-semibold text-zinc-900 dark:text-zinc-100 truncate">{{ $ejemplar->libro->titulo ?? '—' }}</p>
                        </td>
                        <td class="px-3 py-2.5">
                            <span class="font-mono text-xs bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">{{ $ejemplar->codigo_barras ?: '—' }}</span>
                        </td>
                        <td class="px-3 py-2.5 text-center">{{ $ejemplar->numero_copia }}</td>
                        <td class="px-3 py-2.5 text-center">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $ejemplar->estado === 'disponible' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $ejemplar->estado === 'prestado' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                {{ $ejemplar->estado === 'danado' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                {{ $ejemplar->estado === 'perdido' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                {{ ucfirst($ejemplar->estado) }}
                            </span>
                        </td>
                        <td class="px-3 py-2.5 text-center">
                            <div class="flex gap-1.5 justify-center">
                                <button wire:click="downloadBarcode({{ $ejemplar->id }})"
                                    class="p-1.5 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-lg transition group relative">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 010 1.414L14 7h6a2 2 0 012 2v3a2 2 0 01-2 2h-2a2 2 0 01-2-2V8c0-.265.105-.52.293-.707a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414V19a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1z"/>
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Descargar</span>
                                </button>
                                <button wire:click="confirmDelete({{ $ejemplar->id }})"
                                    x-data @click="$dispatch('open-modal', { name: 'modal-eliminar-ejemplar' })"
                                    class="p-1.5 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition group relative">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Eliminar</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                            No hay ejemplares registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $ejemplares->links() }}</div>

    <div x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-eliminar-ejemplar') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-eliminar-ejemplar') open = false"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        style="display:none">
        <div class="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden" @click.stop>
            <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">¿Eliminar ejemplar?</h3>
                <p class="text-xs text-zinc-500 mt-1">Esta acción no se puede deshacer.</p>
            </div>
            <div class="flex gap-3 px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50">
                <button type="button" @click="open = false"
                    class="flex-1 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                    Cancelar
                </button>
                <button type="button" wire:click="deleteEjemplar" wire:loading.attr="disabled"
                    class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                    <span wire:loading.remove wire:target="deleteEjemplar">Sí, eliminar</span>
                    <span wire:loading wire:target="deleteEjemplar">Eliminando...</span>
                </button>
            </div>
        </div>
    </div>
</div>
