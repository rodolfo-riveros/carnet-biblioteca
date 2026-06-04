<div class="w-full bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden p-6 border border-zinc-200 dark:border-zinc-800 flex flex-col gap-4">

    <div class="flex items-center justify-between flex-wrap gap-3">
        <h2 class="text-base font-bold text-zinc-700 dark:text-zinc-200">
            Lista de Libros
        </h2>

        <div class="flex items-center gap-2 flex-wrap">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por título, autor, ISBN..."
                    class="pl-9 pr-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm w-56 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <select wire:model.live="filtroCategoriaId"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 min-w-[160px]">
                <option value="">Categoría</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>

            <select wire:model.live="filtroEstado"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <option value="">Estado</option>
                <option value="disponible">Disponible</option>
                <option value="agotado">Agotado</option>
                <option value="en_reparacion">En reparación</option>
                <option value="dado_de_baja">Dado de baja</option>
            </select>

            <select wire:model.live="perPage"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-xs border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 dark:bg-zinc-800 sticky top-0 z-10">
                <tr>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200 w-16">#</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">TÍTULO</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">AUTOR</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">CÓDIGO</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-20">DISP.</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-24">ESTADO</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-36">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($libros as $libro)
                    <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition">

                        <td class="px-3 py-3 font-medium text-zinc-500 dark:text-zinc-400">{{ $libro->id }}</td>

                        <td class="px-3 py-3 max-w-[200px]">
                            <div class="flex items-center gap-3">
                                @if ($libro->portada_ruta)
                                    <img src="{{ Storage::url($libro->portada_ruta) }}"
                                        class="w-8 h-10 rounded object-cover flex-shrink-0 border border-zinc-200 dark:border-zinc-700" />
                                @else
                                    <div class="w-8 h-10 rounded bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm truncate">{{ $libro->titulo }}</p>
                                    <p class="text-zinc-400 dark:text-zinc-500 text-xs">
                                        @if ($libro->subtitulo)
                                            {{ Str::limit($libro->subtitulo, 30) }} ·
                                        @endif
                                        {{ $libro->categoria->nombre ?? '—' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-3 py-3">
                            <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $libro->autor }}</p>
                            @if ($libro->anio_publicacion)
                                <p class="text-zinc-400 dark:text-zinc-500 text-xs">{{ $libro->editorial ?? '—' }} ({{ $libro->anio_publicacion }})</p>
                            @endif
                        </td>

                        <td class="px-3 py-3">
                            <p class="font-mono text-zinc-900 dark:text-zinc-100">{{ $libro->codigo_interno }}</p>
                            @if ($libro->isbn)
                                <p class="text-zinc-400 dark:text-zinc-500 text-xs">ISBN: {{ $libro->isbn }}</p>
                            @endif
                        </td>

                        <td class="px-3 py-3 text-center">
                            @php
                                $total = $libro->ejemplares->count();
                                $disp = $libro->ejemplares->where('estado', 'disponible')->count();
                            @endphp
                            <span class="font-semibold text-sm {{ $disp > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-500' }}">
                                {{ $disp }}/{{ $total }}
                            </span>
                        </td>

                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $libro->estado === 'disponible'    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $libro->estado === 'agotado'       ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                {{ $libro->estado === 'en_reparacion' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                {{ $libro->estado === 'dado_de_baja'  ? 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $libro->estado === 'disponible'    ? 'bg-green-500' : '' }}
                                    {{ $libro->estado === 'agotado'       ? 'bg-red-500' : '' }}
                                    {{ $libro->estado === 'en_reparacion' ? 'bg-yellow-500' : '' }}
                                    {{ $libro->estado === 'dado_de_baja'  ? 'bg-zinc-400' : '' }}">
                                </span>
                                {{ ucfirst(str_replace('_', ' ', $libro->estado)) }}
                            </span>
                        </td>

                        <td class="px-3 py-3">
                            <div class="flex gap-1.5 justify-center items-center">
                                <a href="{{ route('libros.edit', $libro->id) }}" wire:navigate>
                                    <button class="group relative p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Editar</span>
                                    </button>
                                </a>

                                <button wire:click="confirmDelete({{ $libro->id }})"
                                    x-data @click="$dispatch('open-modal', { name: 'modal-delete-libro' })"
                                    class="group relative p-2 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition">
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
                        <td colspan="7" class="px-4 py-12 text-center">
                            <div class="flex flex-col justify-center items-center gap-3">
                                <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">
                                    No hay libros registrados
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $libros->links() }}</div>
    </div>

    <div x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-delete-libro') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-delete-libro') open = false"
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
                    <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">¿Eliminar libro?</h3>
                    <p class="text-xs text-zinc-500">Esta acción no se puede deshacer.</p>
                </div>
            </div>
            <div class="flex gap-3 px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50">
                <button type="button" @click="open = false"
                    class="flex-1 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                    Cancelar
                </button>
                <button type="button" wire:click="deleteLibro" wire:loading.attr="disabled"
                    class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                    <span wire:loading.remove wire:target="deleteLibro">Sí, eliminar</span>
                    <span wire:loading wire:target="deleteLibro">Eliminando...</span>
                </button>
            </div>
        </div>
    </div>
</div>
