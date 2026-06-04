<div>
    @livewire('admin.role.role-header')

    <div class="w-full bg-zinc-50 dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden p-6 border border-zinc-200 dark:border-zinc-800 flex flex-col gap-4">
        <div class="overflow-x-auto w-full">
            <table class="min-w-full text-xs border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-zinc-800 sticky top-0 z-10">
                    <tr>
                        <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200 w-16">#</th>
                        <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">ROL</th>
                        <th class="px-3 py-3 text-left font-semibold text-zinc-700 dark:text-zinc-200">PERMISOS</th>
                        <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-28">USUARIOS</th>
                        <th class="px-3 py-3 text-center font-semibold text-zinc-700 dark:text-zinc-200 w-28">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="odd:bg-white dark:odd:bg-zinc-900 even:bg-zinc-50 dark:even:bg-zinc-800/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition">
                            <td class="px-3 py-3 font-medium text-zinc-500 dark:text-zinc-400">{{ $role->id }}</td>
                            <td class="px-3 py-3">
                                <p class="font-semibold text-zinc-900 dark:text-zinc-100 capitalize">{{ $role->name }}</p>
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($role->permissions->take(6) as $perm)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                                            {{ $perm->name }}
                                        </span>
                                    @endforeach
                                    @if ($role->permissions->count() > 6)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-zinc-100 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">
                                            +{{ $role->permissions->count() - 6 }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3 text-center text-zinc-600 dark:text-zinc-400">{{ $role->users->count() }}</td>
                            <td class="px-3 py-3 text-center">
                                <div class="flex gap-1.5 justify-center items-center">
                                    <a href="{{ route('roles.edit', $role->id) }}" wire:navigate>
                                        <button class="group relative p-2 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-sm text-zinc-500">No hay roles registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $roles->links() }}</div>
        </div>
    </div>
</div>
