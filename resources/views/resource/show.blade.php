<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Resource') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-engagement', [])

        <div class="col-span-12 px-3 ml-24 mt-2"> 
            @livewire('resource.add-resource', ['uuid'=>request ()->get('resource')])
        </div>
    </div>
</x-app-layout>
