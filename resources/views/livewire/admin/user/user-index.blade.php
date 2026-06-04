<div>
    @livewire('admin.user.user-header')

    <div class="w-full bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden p-6 border border-zinc-200 dark:border-zinc-800 flex flex-col gap-4">

        <div class="flex items-center justify-between flex-wrap gap-3">
            <h2 class="text-base font-bold text-zinc-700 dark:text-zinc-200">Lista de Usuarios</h2>

            <div class="flex items-center gap-2 flex-wrap">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Buscar por nombre o email..."
                        class="pl-9 pr-4 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm w-56 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>

                <select wire:model.live="filtroRol"
                    class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                    @endforeach
                </select>

                <select wire:model.live="perPage"
                    class="px-3 py-2 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-zinc-800 sticky top-0 z-10">
                    <tr>
                        <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200 w-16">#</th>
                        <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">NOMBRE</th>
                        <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">EMAIL</th>
                        <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-28">ROL</th>
                        <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-28">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition">
                            <td class="px-3 py-3 font-medium text-zinc-500 dark:text-zinc-400">{{ $user->id }}</td>
                            <td class="px-3 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ $user->initials() }}
                                    </div>
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 text-sm">{{ $user->name }}</p>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-zinc-500 dark:text-zinc-400">{{ $user->email }}</td>
                            <td class="px-3 py-3 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                    {{ ucfirst($user->roles->first()?->name ?? '—') }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex gap-1.5 justify-center items-center">
                                    <a href="{{ route('usuarios.edit', $user->id) }}" wire:navigate>
                                        <button class="group relative p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">Editar</span>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center">
                                <div class="flex flex-col justify-center items-center gap-3">
                                    <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <p class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">No hay usuarios registrados</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</div>
