<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing Detail') }}
        </h2>
    </x-slot>



    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.admin-menu-dashboard', [])
        @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
        'menu.admin-revenue-submenu',
        []
    )


<div class="col-span-12 px-3 ml-24 mt-2">
    <div class="mx-auto">
        <div class="p-4">
            <div class="p-4 bg-white shadow-md rounded-lg mb-6">
                <h2 class="text-xl md:text-2xl font-semibold text-center">Total Revenue for Last Month</h2>
                <p class="text-3xl md:text-4xl font-bold text-center text-green-600 mt-2">Rp. {{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-white shadow-md p-4 rounded-lg overflow-hidden mb-6">
                <h2 class="text-2xl font-semibold ">Billing</h2>

                @livewire('table.revenue-billing-table', ['status' => request('status')])
            </div>
            <div class="bg-white shadow-md rounded-lg p-4 overflow-hidden">
                <h2 class="text-2xl font-semibold ">Orders</h2>


                @livewire('table.revenue-order-table', ['status' => request('status')])
            </div>
        </div>
    </div>
</div>

    </div>
</x-app-layout>
