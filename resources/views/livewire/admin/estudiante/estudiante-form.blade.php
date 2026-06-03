<div class="w-full py-0 px-4 sm:px-6 lg:px-0 font-sans">
    <div class="w-full bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">

        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 dark:from-indigo-700 dark:to-blue-700 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-white/20 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white tracking-tight">
                        {{ $isEditMode ? 'Editar Estudiante' : 'Nuevo Estudiante' }}
                    </h2>
                    <p class="text-indigo-100 text-xs mt-0.5">
                        {{ $isEditMode ? 'Modifica los datos del estudiante' : 'Registra un nuevo estudiante en el sistema' }}
                    </p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save" class="p-6 space-y-5">

            <div class="flex items-center gap-2 mb-6">
                <div class="flex items-center gap-1.5 text-xs font-medium text-zinc-500 dark:text-zinc-400">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-600 text-white text-xs font-bold">1</span>
                    <span>Datos</span>
                    <svg class="w-4 h-4 mx-1 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="flex items-center gap-1.5 text-xs font-medium text-zinc-400 dark:text-zinc-500">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400 text-xs font-bold">2</span>
                    <span>Institución</span>
                    <svg class="w-4 h-4 mx-1 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <div class="flex items-center gap-1.5 text-xs font-medium text-zinc-400 dark:text-zinc-500">
                    <span class="flex items-center justify-center w-6 h-6 rounded-full bg-zinc-200 dark:bg-zinc-700 text-zinc-500 dark:text-zinc-400 text-xs font-bold">3</span>
                    <span>Académico</span>
                </div>
                <div class="flex-1 h-px bg-zinc-200 dark:bg-zinc-700 ml-3"></div>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Datos Personales</span>
                </div>

                <div class="p-5 space-y-4">
                    <div class="flex items-start gap-5">
                        <div class="flex flex-col items-center gap-2 shrink-0">
                            <div class="relative w-20 h-24 rounded-lg border-2 border-dashed border-zinc-300 dark:border-zinc-600 overflow-hidden bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center">
                                @if ($foto)
                                    <img src="{{ $foto->temporaryUrl() }}" alt="Foto" class="w-full h-full object-cover">
                                @elseif ($foto_ruta)
                                    <img src="{{ Storage::url($foto_ruta) }}" alt="Foto" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex gap-1">
                                <label class="cursor-pointer px-2 py-1 text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20 rounded-md hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition">
                                    <input type="file" wire:model="foto" accept="image/jpeg,image/png" class="hidden">
                                    Foto
                                </label>
                                @if ($foto || $foto_ruta)
                                    <button type="button" wire:click="removeFoto"
                                        class="px-2 py-1 text-xs font-medium text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 rounded-md hover:bg-red-100 dark:hover:bg-red-900/40 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            @error('foto')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex-1 min-w-0 space-y-4">
                            <div class="flex items-end gap-3">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">
                                        DNI <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        wire:model.live.debounce.400ms="dni"
                                        type="text"
                                        placeholder="12345678"
                                        maxlength="8"
                                        class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                            @error('dni')
                                                border-red-400 bg-red-50 dark:bg-red-900/10 focus:ring-red-400
                                            @else
                                                border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 focus:ring-indigo-500 focus:border-indigo-500
                                            @enderror
                                            text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2" />
                                    @error('dni')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <button
                                    type="button"
                                    wire:click="consultarDni"
                                    wire:loading.attr="disabled"
                                    wire:target="consultarDni"
                                    class="flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-semibold text-sm rounded-lg shadow-sm transition whitespace-nowrap">
                                    <span wire:loading.remove wire:target="consultarDni" class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        Buscar
                                    </span>
                                    <span wire:loading wire:target="consultarDni" class="flex items-center gap-1.5">
                                        <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                        </svg>
                                        Buscando...
                                    </span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">
                                Nombres <span class="text-red-500">*</span>
                            </label>
                            <input wire:model.live.debounce.400ms="nombres" type="text" placeholder="Nombres" maxlength="100"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('nombres') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('nombres')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">
                                Ap. Paterno <span class="text-red-500">*</span>
                            </label>
                            <input wire:model.live.debounce.400ms="apellido_paterno" type="text" placeholder="Paterno" maxlength="100"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('apellido_paterno') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('apellido_paterno')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">
                                Ap. Materno <span class="text-red-500">*</span>
                            </label>
                            <input wire:model.live.debounce.400ms="apellido_materno" type="text" placeholder="Materno" maxlength="100"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('apellido_materno') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('apellido_materno')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">
                                Celular <span class="text-red-500">*</span>
                            </label>
                            <input wire:model.live.debounce.400ms="celular" type="text" placeholder="987654321" maxlength="20"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('celular') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('celular')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Celular Alternativo</label>
                            <input wire:model.live.debounce.400ms="celular_alternativo" type="text" placeholder="912345678" maxlength="20"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('celular_alternativo') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Email</label>
                            <input wire:model.live.debounce.400ms="email" type="email" placeholder="correo@ejemplo.com" maxlength="150"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('email') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('email')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Institución y Programa</span>
                </div>

                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">
                                Institución <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.live.debounce.400ms="institucion_id"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('institucion_id') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">— Seleccionar —</option>
                                @foreach ($instituciones as $institucion)
                                    <option value="{{ $institucion->id }}">{{ $institucion->nombre }}</option>
                                @endforeach
                            </select>
                            @error('institucion_id')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Programa de Estudio</label>
                            <select wire:model.live.debounce.400ms="programa_estudio_id"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('programa_estudio_id') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">— Seleccionar —</option>
                                @foreach ($programasEstudio as $programa)
                                    <option value="{{ $programa->id }}">{{ $programa->nombre }}</option>
                                @endforeach
                            </select>
                            @error('programa_estudio_id')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Información Académica</span>
                </div>

                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Año de Ingreso</label>
                            <input wire:model.live.debounce.400ms="anio_ingreso" type="text" placeholder="2020" maxlength="4"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('anio_ingreso') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('anio_ingreso')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Año de Egreso</label>
                            <input wire:model.live.debounce.400ms="anio_egreso" type="text" placeholder="2024" maxlength="4"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('anio_egreso') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('anio_egreso')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Estado <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select wire:model.live.debounce.400ms="estado"
                                    class="w-full px-3.5 py-2 rounded-lg border text-sm transition appearance-none
                                        @error('estado') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                        text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="activo">Activo</option>
                                    <option value="suspendido">Suspendido</option>
                                    <option value="bloqueado">Bloqueado</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </div>
                            </div>
                            @error('estado')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Observaciones</label>
                        <textarea wire:model.live.debounce.400ms="observaciones" rows="2" placeholder="Notas adicionales..." maxlength="5000"
                            class="w-full px-3.5 py-2 rounded-lg border text-sm transition resize-none
                                @error('observaciones') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                </div>
            </div>

            @if ($isEditMode && $carnet_existe)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Carnet de Biblioteca</span>
                </div>

                <div class="p-5 space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-blue-50 dark:bg-blue-900/10 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-200 dark:bg-blue-800 shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-xs text-zinc-600 dark:text-zinc-400">
                            <p><strong>N° Carnet:</strong> {{ $carnet_numero }}</p>
                            <p><strong>Código Barras:</strong> {{ $carnet_codigo_barras }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Fecha de Emisión</label>
                            <input wire:model.live.debounce.400ms="carnet_fecha_emision" type="date"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('carnet_fecha_emision') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('carnet_fecha_emision')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Fecha de Vencimiento</label>
                            <input wire:model.live.debounce.400ms="carnet_fecha_vencimiento" type="date"
                                class="w-full px-3.5 py-2 rounded-lg border text-sm transition
                                    @error('carnet_fecha_vencimiento') border-red-400 bg-red-50 @else border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 @enderror
                                    text-zinc-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('carnet_fecha_vencimiento')<p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-1">
                <a href="{{ route('estudiantes.index') }}" wire:navigate
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-500 dark:text-zinc-400 hover:text-zinc-800 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>

                <div class="flex items-center gap-3">
                    <span class="text-xs text-zinc-400 dark:text-zinc-500">
                        <span class="text-red-500">*</span> Campos obligatorios
                    </span>
                    <button type="submit" wire:loading.attr="disabled" wire:target="save"
                        class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                        <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $isEditMode ? 'Guardar Cambios' : 'Registrar Estudiante' }}
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            Guardando...
                        </span>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
