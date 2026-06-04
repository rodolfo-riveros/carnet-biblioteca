<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            body {
                background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            }
            .auth-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .dark .auth-card {
                background: rgba(15, 23, 42, 0.8);
            }
        </style>
    </head>
    <body class="min-h-screen antialiased flex items-center justify-center p-4 md:p-10">
        {{-- Decoración --}}
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full bg-indigo-500/5 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 rounded-full bg-blue-500/5 blur-3xl"></div>
            <div class="absolute top-1/3 left-1/4 w-60 h-60 rounded-full bg-sky-500/5 blur-3xl"></div>
        </div>

        <div class="relative w-full max-w-sm auth-card rounded-2xl p-8 shadow-2xl">
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
