<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (Auth::user()->role)
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
            @includeWhen(auth()->user(), 'menu.user-dashboard', [])

            <div class="col-span-12 px-6 ml-24 mt-2">
                <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
                    <header class="bg-white dark:bg-slate-900 flex">

                        <ul
                            class="flex gap-1 flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                            <li class="me-2">
                                <a href="{{ route('dashboard.outbound') }}" aria-current="page"
                                    class="inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Out
                                    Bound</a>
                            </li>
                            <li class="me-2">
                                <a href="{{ route('dashboard.outbound.blast-message') }}"
                                    class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Blast
                                    Message</a>
                            </li>
                        </ul>

                    </header>
                    <div>
                        <livewire:table.out-bound-table searchable="name, description" exportable />
                    </div>

                </div>
            </div>
        </div>
    @endif

</x-app-layout>
