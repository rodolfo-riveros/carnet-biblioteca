<div class="w-full py-0 px-4 sm:px-6 lg:px-0 font-sans">
    <div class="w-full bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">

        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 dark:from-indigo-700 dark:to-blue-700 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        {{ $isEditMode ? 'Editar Rol' : 'Nuevo Rol' }}
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1">Define el nombre y los permisos del rol</p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="save" class="p-8 space-y-8">
            <flux:field>
                <flux:label>Nombre del Rol <span class="text-red-500">*</span></flux:label>
                <flux:input wire:model="name" placeholder="ej: bibliotecario" maxlength="255" />
                <flux:error name="name" />
                <p class="text-xs text-zinc-400 mt-1">Se guardará en formato slug (ej: "bibliotecario").</p>
            </flux:field>

            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Permisos</h3>
                    <div class="flex gap-2">
                        <button type="button" wire:click="toggleAll(true)"
                            class="px-3 py-1.5 text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400 rounded-lg hover:bg-indigo-200 transition">
                            Seleccionar todos
                        </button>
                        <button type="button" wire:click="toggleAll(false)"
                            class="px-3 py-1.5 text-xs font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 rounded-lg hover:bg-zinc-200 transition">
                            Deseleccionar todos
                        </button>
                    </div>
                </div>

                <div class="space-y-6">
                    @foreach ($permissionsGrouped as $group => $perms)
                        <div>
                            <h4 class="text-sm font-bold text-zinc-700 dark:text-zinc-300 uppercase tracking-wider mb-3">{{ $group }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                @foreach ($perms as $perm)
                                    <label class="flex items-center gap-2 p-2 rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800 transition
                                        {{ in_array($perm->name, $selectedPermissions) ? 'border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/10' : '' }}">
                                        <input type="checkbox" value="{{ $perm->name }}"
                                            {{ in_array($perm->name, $selectedPermissions) ? 'checked' : '' }}
                                            wire:model="selectedPermissions"
                                            class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="text-xs text-zinc-700 dark:text-zinc-300">{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-zinc-200 dark:border-zinc-700 pt-8">
                <div class="flex justify-between items-center">
                    <a href="{{ route('roles.index') }}" wire:navigate
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition">
                        Cancelar
                    </a>
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-semibold rounded-lg shadow transition text-sm">
                        {{ $isEditMode ? 'Actualizar Rol' : 'Crear Rol' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
