<div class="w-full bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden p-6 border border-zinc-200 dark:border-zinc-800 flex flex-col gap-4">

    {{-- ── Barra de controles ── --}}
    <div class="flex items-center justify-between flex-wrap gap-3">

        <h2 class="text-base font-bold text-zinc-700 dark:text-zinc-200">
            Lista de Instituciones
        </h2>

        <div class="flex items-center gap-3 flex-wrap">

            {{-- Búsqueda --}}
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por nombre o descripción..."
                    class="pl-9 pr-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm w-64 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            {{-- Filtro estado --}}
            <select wire:model.live="filtroActivo"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos los estados</option>
                <option value="1">Activos</option>
                <option value="0">Inactivos</option>
            </select>

            {{-- Por página --}}
            <select wire:model.live="perPage"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <option value="5">5 / pág</option>
                <option value="10">10 / pág</option>
                <option value="20">20 / pág</option>
                <option value="50">50 / pág</option>
            </select>

            {{-- Toggle eliminados --}}
            <label class="flex items-center gap-2 px-3 py-2 bg-zinc-100 dark:bg-zinc-800 rounded-lg cursor-pointer hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                <input type="checkbox" wire:model.live="showDeleted" class="rounded text-indigo-600 focus:ring-indigo-500">
                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Eliminados</span>
            </label>

        </div>
    </div>

    {{-- ── Tabla ── --}}
    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-xs border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 dark:bg-zinc-800 sticky top-0 z-10">
                <tr>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200 w-16">#</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">INSTITUCIÓN</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">DESCRIPCIÓN</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-28">ESTADO</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-36">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($instituciones as $institucion)
                    <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition">

                        <td class="px-3 py-3 font-medium text-zinc-500 dark:text-zinc-400">{{ $institucion->id }}</td>

                        <td class="px-3 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm">{{ $institucion->nombre }}</p>
                                    <p class="text-zinc-400 dark:text-zinc-500 text-xs">
                                        Creada {{ $institucion->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-3 py-3 text-zinc-500 dark:text-zinc-400 max-w-xs">
                            @if ($institucion->descripcion)
                                <p class="truncate">{{ $institucion->descripcion }}</p>
                            @else
                                <span class="text-zinc-300 dark:text-zinc-600 italic">Sin descripción</span>
                            @endif
                        </td>

                        <td class="px-3 py-3 text-center">
                            @if (!$showDeleted)
                                <button
                                    wire:click="toggleActivo({{ $institucion->id }})"
                                    title="{{ $institucion->activo ? 'Clic para desactivar' : 'Clic para activar' }}"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold transition
                                        {{ $institucion->activo
                                            ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 hover:bg-green-200'
                                            : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400 hover:bg-zinc-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $institucion->activo ? 'bg-green-500' : 'bg-zinc-400' }}"></span>
                                    {{ $institucion->activo ? 'Activo' : 'Inactivo' }}
                                </button>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Eliminado
                                </span>
                            @endif
                        </td>

                        <td class="px-3 py-3">
                            <div class="flex gap-1.5 justify-center items-center">
                                @if ($showDeleted)
                                    <button wire:click="restoreInstitucion({{ $institucion->id }})"
                                        class="group relative p-2 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition" title="Restaurar">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Restaurar</span>
                                    </button>

                                    <button wire:click="confirmForceDelete({{ $institucion->id }})"
                                        x-data @click="$dispatch('open-modal', { name: 'modal-force-delete-institucion' })"
                                        class="group relative p-2 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Eliminar permanente</span>
                                    </button>
                                @else
                                    <a href="{{ route('instituciones.edit', $institucion->id) }}" wire:navigate>
                                        <button class="group relative p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Editar</span>
                                        </button>
                                    </a>

                                    <button wire:click="confirmDelete({{ $institucion->id }})"
                                        x-data @click="$dispatch('open-modal', { name: 'modal-delete-institucion' })"
                                        class="group relative p-2 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Eliminar</span>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center">
                            <div class="flex flex-col justify-center items-center gap-3">
                                <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">
                                    {{ $showDeleted ? 'No hay instituciones eliminadas' : 'No hay instituciones registradas' }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $instituciones->links() }}</div>
    </div>

    {{-- ── Modal eliminar (soft) ── --}}
    <div x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-delete-institucion') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-delete-institucion') open = false"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        style="display:none">
        <div class="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden" @click.stop>
            <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">¿Eliminar institución?</h3>
                    <p class="text-xs text-zinc-500">Se moverá a la papelera. Podrás restaurarla.</p>
                </div>
            </div>
            <div class="flex gap-3 px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50">
                <button type="button" @click="open = false"
                    class="flex-1 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                    Cancelar
                </button>
                <button type="button" wire:click="deleteInstitucion" wire:loading.attr="disabled"
                    class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                    <span wire:loading.remove wire:target="deleteInstitucion">Sí, eliminar</span>
                    <span wire:loading wire:target="deleteInstitucion">Eliminando...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Modal eliminar permanente ── --}}
    <div x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-force-delete-institucion') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-force-delete-institucion') open = false"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        style="display:none">
        <div class="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden" @click.stop>
            <div class="px-6 py-5 border-b border-zinc-100 dark:border-zinc-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">¿Eliminar permanentemente?</h3>
                    <p class="text-xs text-zinc-500 text-red-500">Esta acción no se puede deshacer.</p>
                </div>
            </div>
            <div class="flex gap-3 px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50">
                <button type="button" @click="open = false"
                    class="flex-1 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                    Cancelar
                </button>
                <button type="button" wire:click="forceDeleteInstitucion" wire:loading.attr="disabled"
                    class="flex-1 py-2 rounded-lg bg-red-700 hover:bg-red-800 text-white text-sm font-semibold transition">
                    <span wire:loading.remove wire:target="forceDeleteInstitucion">Eliminar permanente</span>
                    <span wire:loading wire:target="forceDeleteInstitucion">Eliminando...</span>
                </button>
            </div>
        </div>
    </div>

</div>
