<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teams') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-setting', [])
        <div class="col-span-12 px-6 ml-24 mt-2">
            <div class="mx-auto">

                <div class="py-3">
                    <div class="z-10">
                        <livewire:table.team-table searchable="name, description" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
