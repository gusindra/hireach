<div class="bg-white dark:bg-slate-900">
    <div class="mx-auto py-3 px-4 sm:px-6 lg:px-2">
        <div class="text-xl text-gray-800 dark:text-slate-300 leading-tight">
            <div class="p-2 bg-white dark:bg-slate-600 border-b border-gray-200 flex justify-between">
                <div class="mt-2 text-2xl">
                    {{auth()->user()->name}} {{ auth()->user()->userBilling && auth()->user()->userBilling->type=='prepaid' ? __('Balance'):__('Usage') }}
                </div>
                @if(auth()->user()->userBilling && auth()->user()->userBilling->type=='prepaid')
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
            </div>
            <div class="my-4 text-right">
                <a href="#">Total {{ auth()->user()->userBilling && auth()->user()->userBilling->type=='prepaid' ? __('Balance'):__('Usage') }}: Rp {{number_format($total)}}</a>
            </div>
        </div>
    </div>
</div>
