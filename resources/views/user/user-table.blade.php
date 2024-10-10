<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @if( Route::currentRouteName() == 'admin.asset' )
        @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
            'menu.admin-menu-asset',
            []
        )
        @else
        @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
            'menu.admin-menu-user',
            []
        )
        @endif
        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto"> 
                    <div class="p-4">
                        @livewire('user.add', ['role' => request()->get('role')])
                    </div> 
                    {{request()->get('role')}}
                    <div class="m-3">
                        <livewire:table.users-table searchable="id, name, email, phone" exportable />
                        {{-- <livewire:table.client-datatables searchable="name, email, gender" exportable /> --}}
                        {{-- <livewire:table.team-table searchable="name, email, gender" exportable /> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
