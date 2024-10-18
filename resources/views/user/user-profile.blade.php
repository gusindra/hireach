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
        @elseif( Route::currentRouteName() == 'autor.show' || Route::currentRouteName() == 'autor.show.profile' )
            @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
                'menu.admin-menu',
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
            ['user' => $user]
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    @if (!$user->isSuper)
                    @livewire('user.generate-api-tokens', ['userId' => $user->id])
                @endif




                    @livewire('user.profile', ['user' => $user])
                    @livewire('user.delete', ['userId' => $user->id])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
