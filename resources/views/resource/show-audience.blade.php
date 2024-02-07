<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Audience') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-engagement', [])

        <div class="col-span-12 px-2 ml-24 mt-2"> 
            @livewire('audience.profile', ['user' => $user])
        </div>
    </div>
</x-app-layout>
