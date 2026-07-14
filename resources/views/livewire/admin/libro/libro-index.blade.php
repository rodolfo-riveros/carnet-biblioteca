<div>
    @livewire('admin.libro.libro-header')
    @livewire('admin.libro.libro-table')

    <div x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail.name === 'modal-importar-libros') open = true"
        x-on:close-modal.window="if ($event.detail.name === 'modal-importar-libros') open = false"
        x-on:importacion-completada.window="open = false"
        x-show="open" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        style="display:none">
        <div class="w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden" @click.stop>
            <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Importar Libros</h3>
                <button type="button" @click="open = false"
                    class="p-1.5 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                @livewire('admin.libro.libro-importar', key('import-' . time()))
            </div>
        </div>
    </div>

</div>
