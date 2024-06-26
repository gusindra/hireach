<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-12">

        <div class="absolute bottom-0 left-0 z-0">
            @includeWhen(auth()->user(), 'menu.user-dashboard', [])
        </div>
    </div>
    @if (Auth::user()->role)
    @endif

    <!-- First User Member to create Team -->
    @if (Auth::user()->currentTeam && Laravel\Jetstream\Jetstream::hasTeamFeatures())
        {{-- {{Auth::user()->currentTeam}} --}}
    @endif

    @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin',
        'dashboard.online',
        ['status' => 'complete']
    )

    @if (auth()->user()->currentTeam)
        <!-- Stat -->
        @includeWhen(false && auth()->user()->currentTeam && auth()->user()->currentTeam->id != env('IN_HOUSE_TEAM_ID'),
            'dashboard.statistic',
            ['status' => 'complete']
        )
        <!-- Asset -->
        @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin',
            'dashboard.asset',
            ['status' => 'complete']
        )
        <!-- Task List -->
        @if (auth()->user()->role()->exists() || auth()->user()->super)
            @includeWhen(auth()->user()->currentTeam->id == env('IN_HOUSE_TEAM_ID') ||
                    (auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin'),
                'dashboard.task',
                ['status' => 'complete']
            )
        @endif
    @endif

    @if (Auth::user()->currentTeam && Auth::user()->currentTeam->user_id == Auth::user()->id)
        <!-- Team Dashboard -->
        <div class="grid grid-cols-12">

            <div class="absolute bottom-0 left-0 z-0">
                @includeWhen(auth()->user(), 'menu.user-dashboard', [])
            </div>

            <div class="col-span-12 px-6 ml-24 mt-2">
                <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
                    @livewire('user.balance', ['userId' => $userId])
                    <x-jet-welcome />
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
