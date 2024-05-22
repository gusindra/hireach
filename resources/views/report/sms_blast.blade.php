<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SMS Detail') }}
        </h2>
    </x-slot>

    <header class="bg-white dark:bg-slate-900 dark:border-slate-600 border-b shadow">
        @include('report.nav')
    </header>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.admin-menu-dashboard', [])

        <div class="col-span-12 px-3 ml-24 mt-2">
            
            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="p-4">
                        <livewire:table.sms-blast-table searchable="{{auth()->user()->super->first()->role == 'superadmin' ? 'user_id, status, created_at':'status, msisdn, created_at, message_content'" exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

