@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Biblioteca La Salle" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="size-7 object-contain dark:brightness-0 dark:invert">
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Sistema Biblioteca La Salle" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="size-7 object-contain dark:brightness-0 dark:invert">
        </x-slot>
    </flux:brand>
@endif
