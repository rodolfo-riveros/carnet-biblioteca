<div class="w-full bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden p-6 border border-zinc-200 dark:border-zinc-800 flex flex-col gap-4">

    <div class="flex items-center justify-between flex-wrap gap-3">
        <h2 class="text-base font-bold text-zinc-700 dark:text-zinc-200">Lista de Préstamos</h2>

        <div class="flex items-center gap-2 flex-wrap">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por estudiante o libro..."
                    class="pl-9 pr-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm w-56 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <select wire:model.live="filtroEstado"
                class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <option value="">Estado</option>
                <option value="prestado">Prestado</option>
                <option value="devuelto">Devuelto</option>
                <option value="vencido">Vencido</option>
                <option value="perdido">Perdido</option>
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
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">ESTUDIANTE</th>
                    <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">LIBROS</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200">PRÉSTAMO</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200">DEV. PREVISTA</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-24">ESTADO</th>
                    <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-36">ACCIONES</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($prestamos as $prestamo)
                    <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition
                        {{ $prestamo->esta_vencido ? 'bg-red-50 dark:bg-red-900/10' : '' }}">

                        <td class="px-3 py-3 font-medium text-zinc-500 dark:text-zinc-400">{{ $prestamo->id }}</td>

                        <td class="px-3 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ strtoupper(substr($prestamo->carnet->estudiante->nombres, 0, 1)) }}{{ strtoupper(substr($prestamo->carnet->estudiante->apellido_paterno, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm">
                                        {{ $prestamo->carnet->estudiante->apellido_paterno }}, {{ $prestamo->carnet->estudiante->nombres }}
                                    </p>
                                    <p class="text-zinc-400 dark:text-zinc-500 text-xs">DNI: {{ $prestamo->carnet->estudiante->dni }} · {{ $prestamo->carnet->estudiante->celular }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-3 py-3">
                            @foreach ($prestamo->libros as $pl)
                                <p class="text-zinc-900 dark:text-zinc-100">{{ $pl->libro?->titulo ?? $pl->titulo_manual }}</p>
                            @endforeach
                        </td>

                        <td class="px-3 py-3 text-center whitespace-nowrap">
                            {{ $prestamo->fecha_prestamo->format('d/m/Y') }}
                        </td>

                        <td class="px-3 py-3 text-center whitespace-nowrap">
                            <span class="{{ $prestamo->esta_vencido ? 'text-red-600 dark:text-red-400 font-bold' : 'text-zinc-700 dark:text-zinc-300' }}">
                                {{ $prestamo->fecha_devolucion_prevista->format('d/m/Y') }}
                            </span>
                            @if ($prestamo->esta_vencido)
                                <br><span class="text-xs text-red-500 font-semibold">{{ $prestamo->dias_vencido }} día(s) vencido</span>
                            @endif
                        </td>

                        <td class="px-3 py-3 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $prestamo->estado === 'prestado' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                {{ $prestamo->estado === 'devuelto' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $prestamo->estado === 'vencido' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                {{ $prestamo->estado === 'perdido' ? 'bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400' : '' }}
                                {{ $prestamo->estado === 'renovado' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $prestamo->estado === 'prestado' ? 'bg-blue-500' : '' }}
                                    {{ $prestamo->estado === 'devuelto' ? 'bg-green-500' : '' }}
                                    {{ $prestamo->estado === 'vencido' ? 'bg-red-500' : '' }}
                                    {{ $prestamo->estado === 'perdido' ? 'bg-zinc-400' : '' }}
                                    {{ $prestamo->estado === 'renovado' ? 'bg-yellow-500' : '' }}">
                                </span>
                                {{ ucfirst($prestamo->estado) }}
                            </span>
                        </td>

                        <td class="px-3 py-3">
                            <div class="flex gap-1.5 justify-center items-center">
                                @if ($prestamo->estado === 'prestado')
                                    <button wire:click="devolver({{ $prestamo->id }})"
                                        class="group relative p-2 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition"
                                        title="Devolver">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 whitespace-nowrap pointer-events-none">Devolver</span>
                                    </button>
                                @endif

                                <a href="{{ route('prestamos.edit', $prestamo->id) }}" wire:navigate>
                                    <button class="group relative p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition">
                                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center">
                            <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">No hay préstamos registrados</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $prestamos->links() }}</div>
    </div>
</div>
