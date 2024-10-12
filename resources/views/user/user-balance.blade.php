<x-app-layout>
    {{-- <header class="bg-white dark:bg-slate-600 shadow">
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
            <big class="font-semibold text-xl text-gray-800 dark:text-slate-300 leading-tight">
                <a class="hover:text-gray-400" href="{{ route('user.show', $user->id) }}">{{ __('User Name') }} : <span
                        class="capitalize">{{ $user->name }}</span></a>
                -
                <a href="#">{{ __('Balance') }} : <span class="capitalize">Rp
                        {{ number_format(balance($user)) }}</span></a>
            </big>
            <br>
            @if (balance($user) != 0)
                <small>
                    {{ __('Estimation') }} :
                    @foreach (estimationSaldo() as $product)
                        <span class="capitalize">{{ $product->name }}
                            ({{ number_format(balance($user) / $product->unit_price) }} SMS)
                        </span>
                    @endforeach
                </small>
            @endif
        </div>
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
            @livewire('saldo.topup', ['user' => $user, 'id' => $id])
        </div>
    </header> --}}
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
            <div class="px-6 py-4 mx-auto my-3 rounded-lg shadow">
                @livewire('saldo.topup', ['user' => $user, 'id' => $id])
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
