<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quotation') }}
        </h2>
    </x-slot>

    @if(request()->routeIs('commercial'))
        @include('assistant.nav')
    @endif

    <div class="hidden">
        @include('assistant.order.nav')
    </div>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin', 'menu.admin-menu-order', [])

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="mx-auto">
                    <div class="p-4">
                        @livewire('commercial.quotation.add', ['source' => NULL, 'model' => NULL])
                        @include('assistant.commercial.table-list', ['active'=>'quotation'])
                    </div>
                    <div class="px-4 py-2">
                        <livewire:table.quotation searchable="title, status, source" exportable/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

