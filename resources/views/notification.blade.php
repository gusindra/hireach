<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notification') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @if(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')))
            @includeWhen(auth()->user(), 'menu.admin-menu-setting', [])
        @else
            @includeWhen(auth()->user(), 'menu.user-dashboard', [])
        @endif

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto p-4">
                    <div class="flex gap-3">
                        @livewire('setting.notification.add')
                        <a class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-slate-900 dark:text-slate-300 uppercase tracking-widest hover:border-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" href="{{route('notification.read.all')}}">
                            Read All
                        </a>
                    </div>
                    <div class="flex flex-col mb-4 mt-5">
                        <form wire:submit.prevent="applyFilter" method="GET" action="{{ route('notification') }}">

                            <div class="flex items-center">
                                <!-- <input type="date" id="filterDate" name="filterDate" wire:model="filterDate"
                                    value="{{ app('request')->input('filterDate') ?? now()->format('Y-m-d') }}"
                                    class="w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"> -->

                                <select name="statusFilter" id="statusFilter" wire:model="statusFilter"
                                    class="block appearance-none w-48 bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:border-blue-500">
                                    <option  value="">All</option>
                                    <option {{app("request")->input("statusFilter")=='unread'?'selected':''}} value="unread">Unread</option>
                                    <option {{app("request")->input("statusFilter")=='read'?'selected':''}} value="read">Read</option>
                                    <option {{app("request")->input("statusFilter")=='deleted'?'selected':''}} value="deleted">Deleted</option>
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
                        <livewire:table.notification-table :filterDate="$filterDate" :statusFilter="$statusFilter" searchable="type, model, notification, status" exportable />
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
