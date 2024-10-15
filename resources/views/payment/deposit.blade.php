<x-app-layout>
    <!-- Team Dashboard -->
    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-balance', [])

        <div class="col-span-12 px-3 ml-24 mt-2">
            <header class="bg-white dark:bg-slate-900 border">
                <div class="mx-auto py-3 px-4 sm:px-6 lg:px-2">
                    <div class="font-semibold text-xl text-gray-800 dark:text-slate-300 leading-tight">
                        <div class="p-2 bg-white dark:bg-slate-600 border-b border-gray-200 flex justify-between">
                            <div class="mt-2 text-2xl">
                                {{auth()->user()->name}} {{ auth()->user()->userBilling->type=='prepaid' ? __('Balance'):__('Usage') }}
                            </div>
                            @if(auth()->user()->userBilling->type=='prepaid')
                            <a href="{{route('payment.topup')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-green-600 hover:text-green-400">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            @endif
                        </div>

                        @php $total = 0; @endphp
                        <div class="p-6 sm:px-20 bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-4">
                            @foreach(auth()->user()->balanceTeam->groupBy('team_id') as $balance)
                            <div>
                                <span class="text-sm">Saldo Team</span>
                                <span class="text-sm uppercase"> {{@$balance[0]->team->name}}:</span>
                                <span class="uppercase">{{$balance[0]->currency}}</span> {{number_format($balance[0]->balance)}}
                            </div>
                            @php $total = $total+$balance[0]->balance; @endphp
                            @endforeach
                            <div class="my-4">
                                <a href="#">Total {{ auth()->user()->userBilling->type=='prepaid' ? __('Balance'):__('Usage') }}: Rp {{number_format($total)}}</a>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
                @if(balance(auth()->user())==0)
                    @if(auth()->user()->userBilling->type=='prepaid')
                        <div class="mt-9 flex justify-center">
                            <img class="w-60"  src="{{url('/assets/img/undraw_add_files.svg')}}" />
                        </div>
                        <div class="text-center p-9">
                            <p class="text-xl">Top up balance</p>
                            <p class="mb-6">Start your campaign and enggangement your customer.</p>
                            <a href="{{route('payment.topup')}}" class="m-6 border text-base bg-yellow-600 rounded text-white border-gray-200 align-middle px-8 py-3">Top-up now</a>
                        </div>
                    @endif
                @else
                <div class="p-2 border-b border-gray-200">
                    <div class="mt-2 text-2xl">
                        History Balance Saldo
                    </div>
                </div>

                <div class="p-3">
                    <livewire:table.balance user="{{auth()->user()->id}}" exportable />
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
