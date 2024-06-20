<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Template') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-engagement', [])

        <div class="col-span-12 px-3 ml-24 mt-2">
            @livewire('campaign.edit', ['campaign' => $campaign->id])
        </div>
    </div>
</x-app-layout>
