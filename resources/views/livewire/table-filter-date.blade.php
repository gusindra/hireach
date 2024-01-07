<div>
<div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3 sm:flex-0 shrink-0">
            <div class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 border-solid dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl border-slate-100 bg-clip-border dark:border-slate-700">
                <div class="p-4 pb-0 rounded-t-2xl">
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full max-w-full px-3 md:flex-0 shrink-0 md:w-6/12">
                            <h6 class="mb-0 dark:text-white">Orders</h6>
                        </div>
                        <div class="flex items-center justify-end w-full max-w-full px-3 md:flex-0 shrink-0 md:w-6/12">
                            <input type="date" name="trip-start" wire:model.debunce.800ms="selectedDate" value="{{date('Y-m-d')}}" class="px-2 rounded-md">
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-4">
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        @if(count($data)>0)
                            @foreach ($data as $order)
                                <li class="relative justify-between block py-2 pb-0 pl-0 pr-4 border-0 rounded-t-inherit rounded-xl text-inherit">
                                    <div class="flex">
                                        <div class="flex items-center">
                                            @if($order->status=='unpaid')
                                            <span class="active:shadow-soft-xs active:opacity-85 ease-soft-in leading-pro text-xs bg-150 bg-x-25 rounded-3.5xl h-6 w-6 mb-0 mr-4 flex items-center justify-center border border-solid border-yellow-600 bg-transparent p-4 text-center align-middle font-bold text-yellow-600 shadow-none transition-all hover:bg-transparent hover:text-yellow-600 hover:opacity-75 hover:shadow-none active:bg-red-600 active:text-black hover:active:bg-transparent hover:active:text-red-600 hover:active:opacity-75 hover:active:shadow-none">
                                                <i class="fas fa-circle text-3xs" aria-hidden="true"></i>
                                            </span>
                                            @else
                                            <button class="active:shadow-soft-xs active:opacity-85 ease-soft-in leading-pro text-xs bg-150 bg-x-25 rounded-3.5xl h-6 w-6 mb-0 mr-4 flex items-center justify-center border border-solid border-lime-500 bg-transparent p-4 text-center align-middle font-bold text-lime-500 shadow-none transition-all hover:bg-transparent hover:text-lime-500 hover:opacity-75 hover:shadow-none active:bg-lime-500 active:text-black hover:active:bg-transparent hover:active:text-lime-500 hover:active:opacity-75 hover:active:shadow-none">
                                                <i class="fas fa-check-circle text-3xs" aria-hidden="true"></i>
                                            </button>
                                            @endif
                                            <div class="flex flex-col">
                                                <h6 class="mb-1 leading-normal text-sm text-slate-700 dark:text-white">{{$order->name}}</h6>
                                                <span class="leading-tight text-xs">{{$order->date->format('d F Y')}}, at {{$order->date->format('H:s')}}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center ml-auto">
                                            @if($order->status=='unpaid')
                                            <p class="relative z-10 inline-block mb-0 font-semibold leading-normal bg-gradient-to-tl dark:text-white text-sm bg-clip-text"> $ 2,500</p>
                                            @else
                                            <p class="relative z-10 inline-block mb-0 font-semibold leading-normal text-transparent bg-gradient-to-tl from-green-600 to-lime-400 text-sm bg-clip-text">+ $ 2,000</p>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="h-px mt-4 mb-2 bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent">
                                </li>
                            @endforeach
                        @else
                            <li class="mb-0 font-semibold leading-normal text-sm text-slate-400">No Data</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
