<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notification') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.admin-menu', [])

        <div class="col-span-12 px-6 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto">
                    <a href="{{route('notification.read.all')}}" class="p-2 text-xs">Read All Notification</a>
                    @livewire('setting.notification.add')
                    
                    <div>
                        <livewire:table.notification-table searchable="id" exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
