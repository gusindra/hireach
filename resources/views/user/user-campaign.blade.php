<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
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
        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu-user-profile',
            []
        )
        <div class="col-span-12 px-6 lg:ml-24 mt-6">
            <div class="bg-white dark:bg-slate-700 shadow-2xl sm:rounded-lg overflow-hidden space-y-6 p-6">


                <div class="flex items-center justify-between border-b pb-4">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Campaign User </h2>
                </div>

                <!-- Table Content -->
                <div class="mx-auto space-y-6">
                    <div class="my-6">
                        @livewire('table.campaign-user-table', ['user' => $user])
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
