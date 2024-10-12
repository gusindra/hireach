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

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    @livewire('user.add-provider', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
