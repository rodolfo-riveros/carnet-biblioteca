<div class="w-full py-0 px-4 sm:px-6 lg:px-0 font-sans">
    <div class="w-full bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">

        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 dark:from-indigo-700 dark:to-blue-700 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        {{ $isEditMode ? 'Editar Préstamo' : 'Nuevo Préstamo' }}
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1">
                        Escanea el carnet del estudiante y los libros para registrar el préstamo
                    </p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save" class="p-8 space-y-8">

            {{-- Escanear carnet --}}
            <div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Escanear Carnet del Estudiante</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Código del Carnet <span class="text-red-500">*</span>
                        </label>
                        <input wire:model.live.debounce.400ms="codigoCarnet" type="text"
                            placeholder="Escanear o escribir código del carnet..."
                            class="w-full px-4 py-3 text-base rounded-lg border text-sm transition border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/10 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Estudiante</label>
                        <div class="w-full px-4 py-3 rounded-lg border text-sm border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                            @if ($estudianteNombre)
                                <p class="font-semibold text-zinc-900 dark:text-white">{{ $estudianteNombre }}</p>
                                <p class="text-xs text-zinc-500">DNI: {{ $estudianteDni }} · Cel: {{ $estudianteCelular }}</p>
                            @else
                                <p class="text-zinc-400 italic">Esperando código de carnet...</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Escanear libros --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Escanear Libros</h3>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Código de Barras del Ejemplar
                    </label>
                    <input wire:model.live="codigoEjemplar" type="text"
                        placeholder="Escanear código de barras del libro..."
                        class="w-full px-4 py-3 text-base rounded-lg border text-sm transition border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/10 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                @if (count($libros) > 0)
                    <div class="space-y-2">
                        @foreach ($libros as $idx => $libro)
                            <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <div class="flex-1">
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm">{{ $libro['titulo'] }}</p>
                                    <p class="text-xs text-zinc-400">Código: {{ $libro['codigo'] }}</p>
                                </div>
                                <button type="button" wire:click="quitarLibro({{ $idx }})"
                                    class="p-1.5 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-zinc-400 italic">No hay libros agregados. Escanea el código de barras de cada ejemplar.</p>
                @endif
            </div>

            {{-- Fecha de devolución --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Fecha de Devolución</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Días de Préstamo</label>
                        <div class="flex gap-2">
                            @foreach ([3, 5, 7, 10, 15] as $d)
                                <button type="button" wire:click="$set('diasPrestamo', {{ $d }})"
                                    class="px-3 py-2 rounded-lg text-sm font-medium transition
                                        {{ $diasPrestamo === $d ? 'bg-indigo-600 text-white' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200' }}">
                                    {{ $d }}d
                                </button>
                            @endforeach
                        </div>
                        @error('diasPrestamo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Días (personalizado)</label>
                        <input wire:model.live="diasPrestamo" type="number" min="1" max="90"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Fecha de Devolución</label>
                        <input wire:model.live="fechaDevolucionPrevista" type="date"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>
            </div>

            {{-- Observaciones --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Observaciones</label>
                    <textarea wire:model.live.debounce.400ms="observaciones" rows="2" placeholder="Notas adicionales..." maxlength="5000"
                        class="w-full px-4 py-2.5 rounded-lg border text-sm transition resize-none border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
            </div>

            <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-2">
                <a href="{{ route('prestamos.index') }}" wire:navigate
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>

                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="min-w-[210px] flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-semibold rounded-lg shadow transition text-sm">
                    <span wire:loading.remove wire:target="save">Registrar Préstamo</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
