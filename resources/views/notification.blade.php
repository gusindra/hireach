<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notification') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.admin-menu-setting', [])

        <div class="col-span-12 px-6 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto">
                    <a href="{{ route('notification.read.all') }}" class="p-2 text-xs">Read All Notification</a>
                    @livewire('setting.notification.add')
                    <div class="flex flex-col mb-4 mt-5">
                        <form wire:submit.prevent="applyFilter" method="GET" action="{{ route('notification') }}">

                            <div class="flex items-center">
                                <input type="date" id="filterDate" name="filterDate" wire:model="filterDate"
                                    value="{{ app('request')->input('filterDate') ?? now()->format('Y-m-d') }}"
                                    class="w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">

                                <select name="statusFilter" id="statusFilter" wire:model="statusFilter"
                                    class="block appearance-none w-48 bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:border-blue-500">
                                    <option value="">All</option>
                                    <option value="unread">Unread</option>
                                    <option value="read">Read</option>
                                    <option value="deleted">Deleted</option>
                                </select>


                                <button wire:click="applyFilter" type="submit"
                                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">Apply Filter</button>


                                @if ($filterDate)
                                    <a href="{{ route('notification') }}"
                                        class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md">Clear Filter</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="relative inline-block">

                    </div>

                    <div>
                        <livewire:table.notification-table :filterDate="$filterDate" :statusFilter="$statusFilter" searchable="type"
                            exportable />
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
