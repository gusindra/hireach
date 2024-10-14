<x-app-layout>
    <x-slot name="header"></x-slot> 

    <div class="grid grid-cols-12">
        @if( Route::currentRouteName() == 'admin.asset' )
            @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
                'menu.admin-menu-asset',
                []
            )
        @elseif( Route::currentRouteName() == 'autor.show' )
            @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
                'menu.admin-menu-setting',
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

        <div class="col-span-12 mx-4 px-4 lg:ml-24 space-y-3">
            <div class="border p-2">
                <div class="bg-white dark:bg-slate-600 col-8 mt-2">
                    <div class="px-6 py-4 mx-auto my-3 rounded-lg shadow">
                        @livewire('saldo.topup', ['user' => $user, 'id' => $id])
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg pb-16">
                    <div class="mx-auto">
                        <div class="space-y-3">
                            @if ($user->id != 0)
                                {{-- @livewire('user.edit', ['userId' => $user->id]) --}}
    
                                <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                                    <div class="p-2 border-b border-gray-200">
                                        <div class="text-2xl">
                                            Overview for
                                        </div>
                                        <form method="get" action="{{ url('/admin/user/' . $user->id) }}">
                                            <select class="dark:bg-slate-800 dark:text-slate-300 h-10 rounded-sm" name="month"
                                                id="month">
                                                <option
                                                    {{ app('request')->input('month') == '1' ? 'selected' : '' }}
                                                    value="1">
                                                    January
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '2' ? 'selected' : '' }}
                                                    value="2">
                                                    February
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '3' ? 'selected' : '' }}
                                                    value="3">
                                                    March
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '4' ? 'selected' : '' }}
                                                    value="4">
                                                    April
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '5' ? 'selected' : '' }}
                                                    value="5">
                                                    May
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '6' ? 'selected' : '' }}
                                                    value="6">
                                                    June
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '7' ? 'selected' : '' }}
                                                    value="7">
                                                    July
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '8' ? 'selected' : '' }}
                                                    value="8">
                                                    August
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '9' ? 'selected' : '' }}
                                                    value="9">
                                                    September</option>
                                                <option
                                                    {{ app('request')->input('month') == '10' ? 'selected' : '' }}
                                                    value="10">
                                                    October
                                                </option>
                                                <option
                                                    {{ app('request')->input('month') == '11' ? 'selected' : '' }}
                                                    value="11">
                                                    November</option>
                                                <option
                                                    {{ app('request')->input('month') == '12' ? 'selected' : '' }}
                                                    value="12">
                                                    December</option>
                                            </select>
                                            <select class="dark:bg-slate-800 dark:text-slate-300 h-10 rounded-sm" name="year"
                                                id="year">
                                                @for ($i = date('Y'); $i > date('Y') - 5; $i--)
                                                    <option
                                                        {{ app('request')->input('year') == $i ? 'selected' : '' }}
                                                        value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <button type="submit"
                                                class="px-2 py-1 bg-gray-800 text-white h-10 rounded-sm">Show</button>
                                        </form>
                                    </div>
    
                                    <div
                                        class="p-6 sm:px-20 bg-gray-200 dark:bg-slate-600 bg-opacity-25 grid grid-cols-1 md:grid-cols-4">
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/client">
                                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                        class="w-16 dark:text-slate-300 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-2 font-semibold text-3xl">
                                                    <span>{{ $user->clients(app('request')->input('month'), app('request')->input('year'))->count() }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/client">Client</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/message">
                                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                        class="w-16 dark:text-slate-300 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-7 font-semibold text-3xl">
                                                    <span>{{ $user->outbounds(app('request')->input('month'), app('request')->input('year'))->count() }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/message">Out Bound</a>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="ml-12">
                                            </div>
                                        </div>
    
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/message">
                                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                                        class="w-16 dark:text-slate-300 text-gray-400">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-7 font-semibold text-3xl">
                                                    <span>{{ $user->inbounds(app('request')->input('month'), app('request')->input('year'))->count() }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/message"> In Bound</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/message">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-16 text-gray-400 dark:text-slate-300"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4">
                                                        </path>
                                                    </svg>
                                                </a>
                                                @if($user->currentTeam)
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-7 font-semibold text-3xl">
                                                    <span>{{ $user->currentTeam->callApi(app('request')->input('month'), app('request')->input('year'))->count() }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/message"> API Call</a>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
    
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/report/sms">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-16 text-gray-400 dark:text-slate-300"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </a>
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-7 font-semibold text-3xl">
                                                    <span>{{ $user->sentsms(app('request')->input('month'), app('request')->input('year'), 'total')->count() }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/report/sms"> Total SMS</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/report/sms">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-16 text-gray-400 dark:text-slate-300"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </a>
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-7 font-semibold text-3xl">
                                                    <span>{{ $user->sentsms(app('request')->input('month'), app('request')->input('year'))->count() }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/report/sms"> SMS DELIVERED</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/report/sms">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-16 text-gray-400 dark:text-slate-300"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </a>
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-7 font-semibold text-3xl">
                                                    <span>{{ $user->sentsms(app('request')->input('month'), app('request')->input('year'), 'UNDELIVERED')->count() }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/report/sms"> SMS
                                                            UNDELIVERED</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="p-6">
                                            <div class="flex items-center">
                                                <a href="http://telixcel.com/report/sms">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-16 text-gray-400 dark:text-slate-300"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                                <div
                                                    class="ml-4 text-gray-600 dark:text-slate-300 leading-7 font-semibold text-2xl">
                                                    <span>Rp
                                                        {{ number_format($user->sentsms(app('request')->input('month'), app('request')->input('year'))->sum('price')) }}</span>
                                                    <div class="mt-2 text-sm text-gray-500 dark:text-slate-300">
                                                        <a href="http://telixcel.com/report/sms"> SMS COST</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    
                                <div
                                    class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-sm col-span-3">
                                    <div class="p-2 border-b border-gray-200">
                                        <div class="mt-2 text-2xl">
                                            Team
                                        </div>
                                    </div>
    
                                    <div class="p-3">
                                        <div class="overflow-x-auto">
                                            <table class="table-auto w-full">
                                                <thead
                                                    class="text-xs font-semibold uppercase text-gray-400 bg-gray-50 dark:bg-slate-700">
                                                    <tr>
                                                        <th class="p-2 whitespace-nowrap">
                                                            <div class="font-semibold text-left">Name</div>
                                                        </th>
                                                        <th class="p-2 whitespace-nowrap">
                                                            <div class="font-semibold text-left">No Member</div>
                                                        </th>
                                                        <th class="p-2 whitespace-nowrap">
                                                            <div class="font-semibold text-left">Balance</div>
                                                        </th>
                                                        <th class="p-2 whitespace-nowrap">
                                                            <div class="font-semibold text-left">Created At</div>
                                                        </th>
                                                        <th class="p-2 whitespace-nowrap">
                                                            <div class="font-semibold text-center">Slug</div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-sm divide-y divide-gray-100">
                                                    @foreach ($user->teams as $team)
                                                        <tr>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="font-medium text-gray-800">
                                                                        {{ $team->name }}</div>
                                                                </div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-left">{{ $team->personal_team }}
                                                                </div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-left">Rp
                                                                    {{ number_format(balance($user, $team->id)) }}
                                                                </div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-left font-medium">
                                                                    {{ $team->created_at->format('d M Y') }}</div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div
                                                                    class="text-lg font-medium text-green-500 text-center">
                                                                    <a
                                                                        href="{{ url('chatting', $team->slug) }}">{{ $team->slug }}</a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
