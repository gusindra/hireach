<x-app-layout>
    <header class="bg-white dark:bg-slate-600 shadow"> </header>
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
            ['user' => $user]
    )

    <!-- Team Dashboard -->
    <div class="col-span-12 px-3 ml-24 mt-2 space-y-3">
        <div class="bg-white col-8 mt-3">
            <div class="bg-white dark:bg-slate-600 col-8 mt-2">
                @livewire('saldo.billing', ['user' => $user, 'id' => $id])
            </div>
            <div class="px-6 py-4 mx-auto my-3 rounded-lg shadow">
            </div>
        </div>
        <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg pb-16">
            <div class="mx-auto">
                <div class="p-2 border-b border-gray-200">
                    <div class="mt-2 text-2xl">
                        History Balance Saldo
                    </div>
                </div>

                <div class="p-3">
                    <livewire:table.balance user="{{ $user->id }}" exportable />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
