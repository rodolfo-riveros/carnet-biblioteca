<div class="w-full bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden p-6 border border-zinc-200 dark:border-zinc-800 flex flex-col gap-4">

    {{-- ── Barra de controles ── --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
        <h2 class="text-base font-bold text-zinc-700 dark:text-zinc-200">Lista de Estudiantes</h2>

        <div class="flex items-center gap-2 flex-wrap">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar..."
                    class="pl-9 pr-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm w-48 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <select wire:model.live="filtroInstitucionId"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 min-w-[180px]">
                <option value="">Institución</option>
                @foreach ($instituciones as $inst)
                    <option value="{{ $inst->id }}">{{ $inst->nombre }}</option>
                @endforeach
            </select>

            <select wire:model.live="filtroProgramaEstudioId"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 min-w-[180px]">
                <option value="">Programa</option>
                @foreach ($programasEstudio as $prog)
                    <option value="{{ $prog->id }}">{{ $prog->nombre }}</option>
                @endforeach
            </select>

            <select wire:model.live="perPage"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>

            <button wire:click="verCarnetsMasivos"
                class="flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg transition shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Masivos
            </button>
        </div>
    </div>

    {{-- ── Tabla ── --}}
    <div class="overflow-x-auto w-full">
        <table class="min-w-full text-xs border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 dark:bg-zinc-800 sticky top-0 z-10">
                <tr>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200 w-16">#</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">ESTUDIANTE</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">DNI</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">INSTITUCIÓN / PROGRAMA</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-24">ESTADO</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-32">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($estudiantes as $estudiante)
                    <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition">

                        <td class="px-3 py-3 font-medium text-zinc-500 dark:text-zinc-400">{{ $estudiante->id }}</td>

                        <td class="px-3 py-3">
                            <div class="flex items-center gap-3">
                                {{-- Avatar con foto o iniciales --}}
                                @if ($estudiante->foto_ruta)
                                    <img src="{{ Storage::url($estudiante->foto_ruta) }}"
                                        class="w-9 h-9 rounded-lg object-cover flex-shrink-0 border border-zinc-200 dark:border-zinc-700" />
                                @else
                                    <div class="w-9 h-9 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0 text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ strtoupper(substr($estudiante->nombres, 0, 1)) }}{{ strtoupper(substr($estudiante->apellido_paterno, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm">
                                        {{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}, {{ $estudiante->nombres }}
                                    </p>
                                    <p class="text-zinc-400 dark:text-zinc-500 text-xs">
                                        {{ $estudiante->celular }}
                                        @if ($estudiante->email) · {{ $estudiante->email }} @endif
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-3 py-3">
                            <span class="font-mono font-semibold text-zinc-900 dark:text-zinc-100">{{ $estudiante->dni }}</span>
                        </td>

                        <td class="px-3 py-3">
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-400">
                                {{ $estudiante->institucion->nombre ?? '—' }}
                            </p>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-0.5">
                                {{ $estudiante->programaEstudio->nombre ?? '—' }}
                            </p>
                        </td>

                        {{-- Estado del estudiante --}}
                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $estudiante->estado === 'activo'    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'   : '' }}
                                {{ $estudiante->estado === 'suspendido' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                {{ $estudiante->estado === 'bloqueado'  ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'           : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $estudiante->estado === 'activo'    ? 'bg-green-500'  : '' }}
                                    {{ $estudiante->estado === 'suspendido' ? 'bg-yellow-500' : '' }}
                                    {{ $estudiante->estado === 'bloqueado'  ? 'bg-red-500'    : '' }}">
                                </span>
                                {{ ucfirst($estudiante->estado) }}
                            </span>
                        </td>

                        {{-- Acciones --}}
                        <td class="px-3 py-3">
                            <div class="flex gap-1 justify-center items-center">

                                {{-- Ver carnet PDF --}}
                                @if ($estudiante->carnet)
                                    <button
                                        wire:click="verCarnetPdf({{ $estudiante->id }})"
                                        x-data @click="$dispatch('open-modal', { name: 'modal-carnet-pdf' })"
                                        class="group relative p-2 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition"
                                        title="Ver carnet">
                                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Ver carnet</span>
                                    </button>
                                @endif

                                {{-- Editar --}}
                                <a href="{{ route('estudiantes.edit', $estudiante->id) }}" wire:navigate>
                                    <button class="group relative p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Editar</span>
                                    </button>
                                </a>

                                {{-- Eliminar --}}
                                <button wire:click="confirmDelete({{ $estudiante->id }})"
                                    x-data @click="$dispatch('open-modal', { name: 'modal-delete-estudiante' })"
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
                        <td colspan="6" class="px-4 py-12 text-center">
                            <div class="flex flex-col justify-center items-center gap-3">
                                <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">No hay estudiantes registrados</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $estudiantes->links() }}</div>
    </div>

    {{-- ══ MODAL: Ver carnet PDF en iframe ════════════════════════════════ --}}
    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-carnet-pdf') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-carnet-pdf') open = false"
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display:none">

        <div class="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden flex flex-col"
            style="height: 85vh"
            @click.stop>

            {{-- Header modal --}}
            <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 bg-gradient-to-r from-blue-700 to-blue-900">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">Carnet de Biblioteca</h3>
                        <p class="text-xs text-blue-200">Documento de identificación</p>
                    </div>
                </div>
                <div class="flex items-center gap-1.5">
                    {{-- Cerrar --}}
                    <button @click="open = false" wire:click="cerrarCarnet"
                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Iframe PDF --}}
            <div class="flex-1 relative bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center p-2">
                {{-- Loader --}}
                <div id="pdf-loader-carnet"
                    class="absolute inset-0 flex flex-col items-center justify-center bg-zinc-100 dark:bg-zinc-800 z-10">
                    <svg class="animate-spin w-8 h-8 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cargando carnet...</p>
                </div>

                @if ($pdfUrl)
                    <iframe
                        src="{{ $pdfUrl }}"
                        class="w-full h-full border-0"
                        onload="document.getElementById('pdf-loader-carnet').style.display='none'">
                    </iframe>
                @endif
            </div>
        </div>
    </div>

    {{-- ══ MODAL: Carnets masivos en iframe ═══════════════════════════════ --}}
    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-carnets-masivos') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-carnets-masivos') open = false"
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display:none">

        <div class="w-full max-w-4xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden flex flex-col"
            style="height: 92vh"
            @click.stop>

            {{-- Header modal --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-zinc-200 dark:border-zinc-700 bg-gradient-to-r from-blue-700 to-blue-900">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white">Carnets Masivos</h3>
                        <p class="text-xs text-blue-200">Vista previa de todos los carnets filtrados</p>
                    </div>
                </div>
                <div class="flex items-center gap-1.5">
                    <button @click="open = false" wire:click="cerrarCarnetsMasivos"
                        class="w-7 h-7 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 text-white transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Iframe PDF --}}
            <div class="flex-1 relative bg-zinc-100 dark:bg-zinc-800">
                <div id="pdf-loader-carnets-masivos"
                    class="absolute inset-0 flex flex-col items-center justify-center bg-zinc-100 dark:bg-zinc-800 z-10">
                    <svg class="animate-spin w-8 h-8 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Cargando carnets masivos...</p>
                </div>

                @if ($massPdfUrl)
                    <iframe
                        src="{{ $massPdfUrl }}"
                        class="w-full h-full border-0"
                        onload="document.getElementById('pdf-loader-carnets-masivos').style.display='none'">
                    </iframe>
                @endif
            </div>
        </div>
    </div>

    {{-- ══ MODAL: Eliminar estudiante ═════════════════════════════════════ --}}
    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-delete-estudiante') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-delete-estudiante') open = false"
        x-show="open"
        x-transition.opacity
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
                    <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100">¿Eliminar estudiante?</h3>
                    <p class="text-xs text-zinc-500">Esta acción no se puede deshacer fácilmente.</p>
                </div>
            </div>
            <div class="flex gap-3 px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50">
                <button type="button" @click="open = false"
                    class="flex-1 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition">
                    Cancelar
                </button>
                <button type="button" wire:click="deleteEstudiante" wire:loading.attr="disabled"
                    class="flex-1 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                    <span wire:loading.remove wire:target="deleteEstudiante">Sí, eliminar</span>
                    <span wire:loading wire:target="deleteEstudiante">Eliminando...</span>
                </button>
            </div>
        </div>
    </div>

</div>