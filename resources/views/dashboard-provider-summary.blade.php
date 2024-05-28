<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing Detail') }}
        </h2>
    </x-slot>



    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.admin-menu-dashboard', [])

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="mx-auto">
                <div class="p-4">
                    @includeWhen(auth()->user()->super,
                        'dashboard.provider-summary',
                        []
                    )
                    <livewire:table.provider-table searchable="name" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
