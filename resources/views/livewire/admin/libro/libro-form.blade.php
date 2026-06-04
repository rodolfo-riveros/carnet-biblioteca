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
                        {{ $isEditMode ? 'Editar Libro' : 'Registrar Nuevo Libro' }}
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1">
                        {{ $isEditMode
                            ? 'Modifica la información del libro'
                            : 'Completa los datos para registrar un nuevo libro' }}
                    </p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save" class="p-8 space-y-8">

            {{-- Datos Generales --}}
            <div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Datos Generales</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Título <span class="text-red-500">*</span>
                        </label>
                        <input wire:model.live.debounce.400ms="titulo" type="text" placeholder="Título del libro" maxlength="300"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('titulo') border-red-400 bg-red-50 dark:bg-red-900/10 focus:ring-red-400
                                @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2" />
                        @error('titulo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Subtítulo</label>
                        <input wire:model.live.debounce.400ms="subtitulo" type="text" placeholder="Subtítulo" maxlength="300"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('subtitulo') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Autor <span class="text-red-500">*</span>
                        </label>
                        <input wire:model.live.debounce.400ms="autor" type="text" placeholder="Nombre del autor" maxlength="200"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('autor') border-red-400 bg-red-50 dark:bg-red-900/10 focus:ring-red-400
                                @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2" />
                        @error('autor')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Co-autores</label>
                        <input wire:model.live.debounce.400ms="co_autores" type="text" placeholder="Co-autores" maxlength="300"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('co_autores') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>
            </div>

            {{-- Identificación --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Identificación</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Código Interno <span class="text-red-500">*</span>
                            <span class="text-xs text-zinc-400 font-normal">(auto según título)</span>
                        </label>
                        <input wire:model.live.debounce.400ms="codigo_interno" type="text" placeholder="Se genera automáticamente" maxlength="50"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('codigo_interno') border-red-400 bg-red-50 dark:bg-red-900/10 focus:ring-red-400
                                @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 focus:ring-indigo-500 focus:border-indigo-500 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2" />
                        @error('codigo_interno')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            ISBN
                            <span class="text-xs text-zinc-400 font-normal">(auto según datos)</span>
                        </label>
                        <input wire:model.live.debounce.400ms="isbn" type="text" placeholder="Se genera automáticamente" maxlength="20"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('isbn') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                        @error('isbn')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Publicación --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Publicación</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Editorial</label>
                        <input wire:model.live.debounce.400ms="editorial" type="text" placeholder="Editorial" maxlength="150"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('editorial') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Lugar de Publicación</label>
                        <input wire:model.live.debounce.400ms="lugar_publicacion" type="text" placeholder="Ciudad, País" maxlength="100"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('lugar_publicacion') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Año de Publicación</label>
                        <input wire:model.live.debounce.400ms="anio_publicacion" type="text" placeholder="2024" maxlength="4"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('anio_publicacion') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                        @error('anio_publicacion')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Edición</label>
                        <input wire:model.live.debounce.400ms="edicion" type="text" placeholder="1ra edición" maxlength="50"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('edicion') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Idioma</label>
                        <input wire:model.live.debounce.400ms="idioma" type="text" placeholder="Español" maxlength="50"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('idioma') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Páginas</label>
                        <input wire:model.live.debounce.400ms="paginas" type="number" placeholder="250" min="1"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('paginas') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                        @error('paginas')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            {{-- Clasificación --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Clasificación</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Categoría</label>
                        <select wire:model.live.debounce.400ms="categoria_id"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('categoria_id') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">— Seleccionar —</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Ubicación (Estante)</label>
                        <input wire:model.live.debounce.400ms="ubicacion_estante" type="text" placeholder="A-1" maxlength="50"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('ubicacion_estante') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Signatura</label>
                        <input wire:model.live.debounce.400ms="signatura" type="text" placeholder="863.4 P438" maxlength="100"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('signatura') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>
            </div>

            {{-- Ejemplares --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Ejemplares</h3>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Cantidad de ejemplares
                    </label>
                    <input wire:model.live="cantidadEjemplares" type="number" min="1" max="100"
                        class="w-32 px-4 py-2.5 rounded-lg border text-sm transition border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                <div class="space-y-2">
                    @foreach ($ejemplares as $idx => $ej)
                        <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <span class="text-sm font-bold text-zinc-500 dark:text-zinc-400 w-10 text-center">#{{ $ej['numero_copia'] }}</span>
                            <div class="flex-1">
                                <input wire:model.live.debounce.400ms="ejemplares.{{ $idx }}.codigo_barras"
                                    type="text"
                                    placeholder="Escanear código de barras o dejar vacío para auto-generar"
                                    maxlength="100"
                                    class="w-full px-3 py-2 rounded-lg border text-sm transition border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                            <div class="flex-1 max-w-[200px]">
                                <input wire:model.live.debounce.400ms="ejemplares.{{ $idx }}.notas"
                                    type="text"
                                    placeholder="Notas (opcional)"
                                    maxlength="255"
                                    class="w-full px-3 py-2 rounded-lg border text-sm transition border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('ejemplares.*.codigo_barras')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                <p class="mt-2 text-xs text-zinc-400">Si dejas el código de barras vacío, se generará automáticamente al guardar.</p>
            </div>

            {{-- Descripción --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Descripción</h3>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Descripción</label>
                        <textarea wire:model.live.debounce.400ms="descripcion" rows="3" placeholder="Descripción del libro..." maxlength="5000"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition resize-none
                                @error('descripcion') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Palabras Clave</label>
                        <input wire:model.live.debounce.400ms="palabras_clave" type="text" placeholder="novela, ficción, aventura" maxlength="500"
                            class="w-full px-4 py-2.5 rounded-lg border text-sm transition
                                @error('palabras_clave') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    </div>
                </div>
            </div>

            {{-- Portada --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Portada</h3>
                </div>

                <div class="flex items-start gap-5">
                    <div class="flex flex-col items-center gap-2 shrink-0">
                        <div class="relative w-24 h-32 rounded-lg border-2 border-dashed border-zinc-300 dark:border-zinc-600 overflow-hidden bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center">
                            @if ($portada)
                                <img src="{{ $portada->temporaryUrl() }}" alt="Portada" class="w-full h-full object-cover">
                            @elseif ($portada_ruta)
                                <img src="{{ Storage::url($portada_ruta) }}" alt="Portada" class="w-full h-full object-cover">
                            @else
                                <svg class="w-10 h-10 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="flex gap-1">
                            <label class="cursor-pointer px-2 py-1 text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition">
                                <input type="file" wire:model="portada" accept="image/*" capture="environment" class="hidden">
                                Portada
                            </label>
                            @if ($portada || $portada_ruta)
                                <button type="button" wire:click="removePortada"
                                    class="px-2 py-1 text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-md hover:bg-red-100 dark:hover:bg-red-900/40 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        @error('portada')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-2">
                        <p>Formatos: JPG, PNG</p>
                        <p>Tamaño máximo: 2MB</p>
                    </div>
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
                <a href="{{ route('libros.index') }}" wire:navigate
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>

                <button type="submit" wire:loading.attr="disabled" wire:target="save"
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
                        {{ $isEditMode ? 'Actualizar Libro' : 'Registrar Libro' }}
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
