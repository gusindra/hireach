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

        {{-- @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
            'menu.admin-submenu',
            []
        ) --}}

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="flex flex-row-reverse ">
                        @livewire('department.setting-contact')
                    </div>
                    <div class="m-5 space-y-6">
                        <div class="bg-gradient-to-r from-orange-400 to-yellow-500 shadow-md rounded-md p-6 text-center text-white">
                            <h2 class="text-lg font-semibold mb-1">Total Messages</h2>
                            <p class="text-3xl font-bold">{{ $blastCount }}</p>
                            <span class="text-sm font-light mt-2 block">Messages sent to the department</span>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div class="bg-white shadow-md rounded-md p-4">
                                <h3 class="text-xl font-semibold mb-3">Department User Table</h3>
                                <livewire:table.department-user-table
                                    :departmentId="$department->id"
                                    :userId="$user->id"
                                    searchable="source_id, name, ancestors, parent, client_id"
                                    exportable
                                />
                            </div>

                            <div class="bg-white shadow-md rounded-md p-4">
                                <h3 class="text-xl font-semibold mb-3">Blast Messages Table</h3>
                                @livewire('table.user-blast-message-departement-table', ['departmentId' => $department->id])
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
