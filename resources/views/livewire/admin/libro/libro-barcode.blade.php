<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Gestionar Códigos de Barras</h2>
        <div class="flex gap-3">
            <button type="button" x-data @click="$dispatch('open-modal', { name: 'modal-generar-etiquetas' })"
                class="flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Generar Etiquetas
            </button>
            <button type="button" x-data @click="$dispatch('open-modal', { name: 'modal-importar-codigos' })"
                class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Importar Códigos
            </button>
        </div>
    </div>

    @livewire('admin.libro.libro-barcode-table')

    <div x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-generar-etiquetas') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-generar-etiquetas') open = false"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display:none">
        <div class="w-full max-w-4xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden" @click.stop>
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Generar Etiquetas de Códigos de Barras</h3>
                <button type="button" @click="open = false"
                    class="p-1.5 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                @livewire('admin.libro.libro-etiquetas-generador', key('etiquetas-'.time()))
            </div>
        </div>
    </div>

    <div x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-importar-codigos') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-importar-codigos') open = false"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display:none">
        <div class="w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden" @click.stop>
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Importar Códigos de Barras</h3>
                <button type="button" @click="open = false"
                    class="p-1.5 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                @livewire('admin.libro.libro-importar-codigos', key('import-codigos-'.time()))
            </div>
        </div>
    </div>
</div>
