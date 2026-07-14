<div class="space-y-4">
    <div class="flex items-center gap-3">
        <label class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
            <input type="checkbox" wire:model.live="faltaCodigo" class="rounded border-zinc-300 dark:border-zinc-600 text-indigo-600 focus:ring-indigo-500">
            Solo libros sin código de barras
        </label>

        <x-flux::button wire:click="generateLabels" class="ml-auto">
            Generar PDF
        </x-flux::button>
    </div>

    @if ($showPreview)
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <p class="text-sm text-green-800 dark:text-green-300 font-semibold">PDF generado correctamente.</p>
            <p class="text-xs text-green-600 dark:text-green-400 mt-1">{{ count($libros) }} etiquetas generadas.</p>
        </div>
    @endif

    @if (count($libros) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs border border-zinc-200 dark:border-zinc-700 rounded-lg">
                <thead class="bg-gray-100 dark:bg-zinc-800">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold text-zinc-700 dark:text-zinc-200">ID</th>
                        <th class="px-3 py-2 text-left font-semibold text-zinc-700 dark:text-zinc-200">Libro</th>
                        <th class="px-3 py-2 text-left font-semibold text-zinc-700 dark:text-zinc-200">Código Barras</th>
                        <th class="px-3 py-2 text-center font-semibold text-zinc-700 dark:text-zinc-200">Copia</th>
                        <th class="px-3 py-2 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-20">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @foreach ($libros as $item)
                        @php
                            $bc = $item['codigo_barras'] ?? '';
                            $itemTitulo = $item['titulo'] ?? '';
                            $itemCopia = $item['numero_copia'] ?? '';
                        @endphp
                        <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition">
                            <td class="px-3 py-2 font-medium text-zinc-500">{{ $item['id'] ?? '—' }}</td>
                            <td class="px-3 py-2 max-w-[200px] truncate font-semibold text-zinc-900 dark:text-zinc-100">{{ $itemTitulo }}</td>
                            <td class="px-3 py-2 font-mono text-xs">{{ $bc ?: '—' }}</td>
                            <td class="px-3 py-2 text-center">{{ $itemCopia ?: '—' }}</td>
                            <td class="px-3 py-2 text-center">
                                <button wire:click="generarYDescargar({{ $item['ejemplar_id'] ?? $item['id'] }})"
                                    class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-lg transition">
                                    Descargar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-6">No hay libros que cumplan los criterios.</p>
    @endif
</div>
