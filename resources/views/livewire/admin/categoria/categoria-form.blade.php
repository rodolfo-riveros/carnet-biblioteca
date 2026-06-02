<div class="w-full py-0 px-4 sm:px-6 lg:px-0 font-sans">
    <div class="w-full bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">

        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 dark:from-indigo-700 dark:to-blue-700 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        {{ $isEditMode ? 'Editar Categoría' : 'Registrar Nueva Categoría' }}
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1">
                        {{ $isEditMode
                            ? 'Modifica la información de la categoría'
                            : 'Completa los datos para registrar una nueva categoría' }}
                    </p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save" class="p-8 space-y-8">

            <div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Información de la Categoría</h3>
                </div>

                <div class="grid grid-cols-1 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input
                            wire:model.live.debounce.400ms="nombre"
                            type="text"
                            placeholder="Ej: Literatura"
                            maxlength="100"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('nombre')
                                    border-red-400 bg-red-50 dark:bg-red-900/10 focus:ring-red-400
                                @else
                                    border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 focus:ring-indigo-500 focus:border-indigo-500
                                @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2" />
                        @error('nombre')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-zinc-400">{{ strlen($nombre) }}/100 caracteres</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Descripción
                            <span class="text-zinc-400 font-normal">(opcional)</span>
                        </label>
                        <textarea
                            wire:model.live.debounce.400ms="descripcion"
                            rows="3"
                            placeholder="Descripción breve de la categoría"
                            maxlength="255"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition resize-none
                                @error('descripcion')
                                    border-red-400 bg-red-50 dark:bg-red-900/10 focus:ring-red-400
                                @else
                                    border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 focus:ring-indigo-500 focus:border-indigo-500
                                @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2"></textarea>
                        @error('descripcion')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-1 text-xs text-zinc-400">{{ strlen($descripcion) }}/255 caracteres</p>
                    </div>

                    @if ($isEditMode)
                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-xl">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                                Estado de la categoría
                            </label>
                            <label class="flex items-center gap-4 cursor-pointer w-fit group">
                                <div class="relative">
                                    <input type="checkbox" wire:model.live="activo" class="sr-only peer" />
                                    <div class="w-11 h-6 bg-zinc-300 dark:bg-zinc-600 peer-checked:bg-indigo-600 rounded-full transition-colors duration-200 peer-focus:ring-2 peer-focus:ring-indigo-500 peer-focus:ring-offset-1"></div>
                                    <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 peer-checked:translate-x-5"></div>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold {{ $activo ? 'text-indigo-600 dark:text-indigo-400' : 'text-zinc-500 dark:text-zinc-400' }}">
                                        {{ $activo ? '✓ Activo' : '✗ Inactivo' }}
                                    </span>
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-0.5">
                                        {{ $activo
                                            ? 'La categoría aparece disponible en el sistema'
                                            : 'La categoría no aparecerá en los selectores' }}
                                    </p>
                                </div>
                            </label>
                        </div>
                    @endif

                </div>
            </div>

            <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

            <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        Los campos marcados con <span class="text-red-500 font-bold">*</span> son obligatorios.
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-2">
                <a href="{{ route('categorias.index') }}" wire:navigate
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="min-w-[210px] flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-semibold rounded-lg shadow transition text-sm">

                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                        Guardando...
                    </span>

                    <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $isEditMode ? 'Actualizar Categoría' : 'Registrar Categoría' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
