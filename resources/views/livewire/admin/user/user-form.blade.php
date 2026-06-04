<div class="w-full py-0 px-4 sm:px-6 lg:px-0 font-sans">
    <div class="w-full bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">

        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 dark:from-indigo-700 dark:to-blue-700 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        {{ $isEditMode ? 'Editar Usuario' : 'Registrar Nuevo Usuario' }}
                    </h2>
                    <p class="text-indigo-100 text-sm mt-1">
                        {{ $isEditMode
                            ? 'Modifica los datos del usuario del sistema'
                            : 'Crea un nuevo usuario para acceder al sistema' }}
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
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Datos del Usuario</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Nombre <span class="text-red-500">*</span></flux:label>
                        <flux:input wire:model="name" placeholder="Nombre completo" maxlength="255" />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Email <span class="text-red-500">*</span></flux:label>
                        <flux:input wire:model="email" type="email" placeholder="correo@ejemplo.com" maxlength="255" />
                        <flux:error name="email" />
                    </flux:field>

                    <flux:field>
                        <flux:label>
                            Contraseña @if(!$isEditMode)<span class="text-red-500">*</span>@endif
                        </flux:label>
                        <flux:input wire:model="password" type="password" placeholder="Mín. 8 caracteres" viewable />
                        <flux:error name="password" />
                        @if ($isEditMode)
                            <p class="text-xs text-zinc-400 mt-1">Deja en blanco para mantener la actual.</p>
                        @endif
                    </flux:field>

                    <flux:field>
                        <flux:label>Confirmar Contraseña</flux:label>
                        <flux:input wire:model="password_confirmation" type="password" placeholder="Repite la contraseña" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Rol <span class="text-red-500">*</span></flux:label>
                        <flux:select wire:model="role">
                            <option value="">— Seleccionar —</option>
                            @foreach ($roles as $r)
                                <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                            @endforeach
                        </flux:select>
                        <flux:error name="role" />
                    </flux:field>
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
                <a href="{{ route('usuarios.index') }}" wire:navigate
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>

                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="min-w-[210px] flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 text-white font-semibold rounded-lg shadow transition text-sm">
                    <span wire:loading.remove wire:target="save">
                        {{ $isEditMode ? 'Actualizar Usuario' : 'Registrar Usuario' }}
                    </span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
