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
        <div>
            <div class="grid grid-cols-12">
                @includeWhen(auth()->user(), 'menu.user-dashboard', [])

                <div class="col-span-12 px-6 ml-24 mt-2">

                    <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">

                        <div class="bg-gray-200 py-8">
                            <div class="flex space-x-6">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="">
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                class="w-16 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                        </a>
                                        <div
                                            class="ml-4 text-gray-600 dark:text-gray-300 leading-2 font-semibold text-3xl">
                                            <span>{{ $totalCount }}</span>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <a href="">Total Outbound</a>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5>Request : {{ $requestsCount }}</h5>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5>Blast Message : {{ $blastMessageCount }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="{{ route('message') }}">
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                class="w-16 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                        </a>

                                        <div class="ml-4 text-gray-600 dark:text-gray-300 leading-7 font-semibold text-3xl">
                                            <!-- <span>{{ $blastMessageClientCount }}</span> -->
                                            <div class="text-gray-600 dark:text-gray-300 leading-7 font-semibold text-3xl">
                                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                    <a href="">Total Clients</a>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5 href="">Blast Message: {{ $blastMessageClientCount }}</h5>
                                            </div>

                                            <span></span>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5 href="">Clients Request : {{ $requestsClients }}</h5>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="ml-12">
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="">
                                            <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                class="w-16 text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                        <div
                                            class="ml-4 text-gray-600 dark:text-gray-300 leading-7 font-semibold text-3xl">
                                            <span>{{ $totalSuccessCount }}</span>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <a href=""> Total Success</a>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5>Request :{{ $successRequest }} </h5>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5>Blast Message :{{ $blastMessageSuccessCount }} </h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </a>
                                        <div
                                            class="ml-4 text-gray-600 dark:text-gray-300 leading-7 font-semibold text-3xl">
                                            <span>{{ $totalFailCount }}</span>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <a href=""> Total Fail</a>
                                            </div>

                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5>Request :{{ $failRequest }} </h5>
                                            </div>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                                <h5>Blast Message :{{ $blastMessageFailCount }} </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="flex flex-col mb-4 mt-5">
                            <form method="GET" action="{{ route('dashboard.outbound') }}">
                                <div class="flex items-center">
                                    <!-- Input bulan dan tahun dengan nilai default tanggal dan tahun sekarang -->
                                    <input type="month" id="filterMonth" name="filterMonth" wire:model="filterMonth"
                                        value="{{ app('request')->input('filterMonth') ?? date('Y-m') }}"
                                        class="w-48 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                                    <!-- Tombol "Apply Filter" -->
                                    <button type="submit"
                                        class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">Apply
                                        Filter</button>
                                    <!-- Tombol "Clear Filter" -->
                                    @if ($filterMonth)
                                        <a href="{{ route('dashboard.outbound') }}"
                                            class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md">Clear Filter</a>
                                    @endif
                                </div>
                            </form>
                        </div>





                        <div>
                            <livewire:table.out-bound-table :filterMonth="$filterMonth" searchable="name, description"
                                exportable />

                        </div>

                        <div>
                            <livewire:table.sms-blast-table :filterMonth="$filterMonth" searchable="name, description"
                                exportable />
                        </div>

                    </div>
                </div>
            </div>

    @endif

</x-app-layout>
