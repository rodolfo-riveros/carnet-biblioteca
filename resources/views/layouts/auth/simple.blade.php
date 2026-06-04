<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased flex items-center justify-center p-4 md:p-10 bg-linear-to-br from-zinc-950 via-accent-950 to-zinc-950">
        {{-- Decoración --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full bg-accent/5 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 rounded-full bg-accent/5 blur-3xl"></div>
            <div class="absolute top-1/3 left-1/4 w-60 h-60 rounded-full bg-accent/5 blur-3xl"></div>
        </div>

        <div class="relative w-full max-w-sm rounded-2xl p-8 shadow-2xl bg-zinc-900/90 backdrop-blur-2xl border border-accent/15 shadow-black/40">
            <div class="flex flex-col gap-2">
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
