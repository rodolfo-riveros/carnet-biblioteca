<div>
    <div class="flex items-center gap-2 mb-5">
        <div class="flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
        </div>
        <span class="text-sm font-semibold text-zinc-800 dark:text-zinc-200">Importar Libros</span>
    </div>

    <div class="space-y-4">
        <div class="flex items-center justify-between p-4 bg-indigo-50 dark:bg-indigo-900/10 rounded-lg border border-indigo-200 dark:border-indigo-800">
            <div class="text-xs text-indigo-700 dark:text-indigo-300">
                <p class="font-semibold">1. Descarga la plantilla</p>
                <p class="text-indigo-500 dark:text-indigo-400 mt-0.5">Completa los datos de los libros en el archivo Excel.</p>
            </div>
            <button type="button" wire:click="descargarPlantilla" wire:loading.attr="disabled"
                class="flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-semibold text-xs rounded-lg shadow-sm transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Descargar Plantilla
            </button>
        </div>

        <div>
            <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">2. Sube el archivo lleno</label>
            <div class="flex items-center gap-3">
                <input type="file" wire:model="archivo" accept=".xlsx,.xls,.csv"
                    class="block w-full text-xs text-zinc-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/20 dark:file:text-indigo-300 transition" />
                <span wire:loading wire:target="archivo" class="text-xs text-indigo-500">Procesando...</span>
            </div>
            @error('archivo')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        @if (!empty($preview))
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                <div class="max-h-48 overflow-y-auto">
                    <table class="min-w-full text-xs">
                        <thead class="bg-zinc-100 dark:bg-zinc-800 sticky top-0">
                            <tr>
                                @foreach (array_keys($preview[0] ?? []) as $col)
                                    <th class="px-2 py-1.5 text-left font-semibold text-zinc-600 dark:text-zinc-400 whitespace-nowrap">{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach ($preview as $row)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    @foreach ($row as $val)
                                        <td class="px-2 py-1 text-zinc-700 dark:text-zinc-300 whitespace-nowrap">{{ $val }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-3 py-2 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500">
                    {{ count($preview) }} registro(s) encontrados
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-xs text-zinc-500">
                    @if ($importados > 0 || $fallidos > 0)
                        <span class="text-green-600 font-semibold">{{ $importados }} importados</span>
                        @if ($fallidos > 0)
                            <span class="text-red-500 font-semibold ml-2">{{ $fallidos }} fallidos</span>
                        @endif
                    @endif
                </div>
                <button type="button" wire:click="importar" wire:loading.attr="disabled" wire:target="importar"
                    class="flex items-center gap-1.5 px-5 py-2 bg-green-600 hover:bg-green-700 disabled:opacity-60 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                    <span wire:loading.remove wire:target="importar" class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Importar {{ count($preview) }} registro(s)
                    </span>
                    <span wire:loading wire:target="importar" class="flex items-center gap-1.5">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                        </svg>
                        Importando...
                    </span>
                </button>
            </div>

            @if (!empty($errores))
                <div class="p-3 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-lg">
                    <p class="text-xs font-semibold text-red-700 dark:text-red-300 mb-1">Errores:</p>
                    <ul class="text-xs text-red-600 dark:text-red-400 space-y-0.5">
                        @foreach ($errores as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </div>
</div>
