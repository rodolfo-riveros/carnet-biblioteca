<div class="space-y-5">
    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-5 border border-zinc-200 dark:border-zinc-700">
        <h4 class="text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-3">Configuración de Generación</h4>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">ID Inicio</label>
                <input type="number" wire:model="startId" min="1" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm dark:bg-zinc-700" />
            </div>
            <div>
                <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1.5">ID Fin</label>
                <input type="number" wire:model="endId" min="1" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm dark:bg-zinc-700" />
            </div>
            <div class="flex items-end">
                <button wire:click="generarEtiquetas" wire:loading.attr="disabled"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-lg transition">
                    <span wire:loading.remove wire:target="generarEtiquetas">Generar PDF</span>
                    <span wire:loading wire:target="generarEtiquetas" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                        Generando...
                    </span>
                </button>
            </div>
        </div>
    </div>

    @if($pdfUrl)
        <div class="mt-5 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-green-800 dark:text-green-300">PDF Generado</p>
                    <p class="text-xs text-green-600 dark:text-green-400">Etiquetas para ejemplares {{ $startId }} - {{ $endId }}</p>
                </div>
                <a href="{{ $pdfUrl }}" target="_blank"
                    class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 010 1.414L14 7h6a2 2 0 012 2v3a2 2 0 01-2 2h-2a2 2 0 01-2-2V8c0-.265.105-.52.293-.707a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414V19a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1z"/>
                    </svg>
                    Descargar PDF
                </a>
            </div>
        </div>
    @endif

    @if($message)
        <div class="mt-5 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
            <p class="text-sm font-semibold text-red-800 dark:text-red-300">{{ $message }}</p>
        </div>
    @endif
</div>
