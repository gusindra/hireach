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
                    @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin',
                        'dashboard.order-summary',
                        ['status' => 'complete']
                    )
                    <livewire:table.billings-table searchable="name, email, gender" exportable />
                    <livewire:table.order searchable="name, email, gender" exportable />

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
