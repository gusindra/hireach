<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>

    @if (request()->routeIs('commercial'))
        @include('assistant.nav')
    @endif

    <div class="hidden">
        @include('assistant.order.nav')
    </div>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper ||
                (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu-order',
            []
        )

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="p-4">
                        @livewire('order.add', ['source' => null, 'model' => null])
                    </div>
                    <div class="px-4 py-2">
                        <livewire:table.order-admin-table searchable="name" exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
