<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Channel') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-channel', [])

        <div class="w-48 ml-24 mt-16 col-span-3 z-10 transition-transform -translate-x-full sm:translate-x-0 fixed  inset-0 bg-white"> 
            <div class="overflow-y-auto h-full bg-gray-100 shado-md">
                <div class="h-screen"> 
                    <div class="px-4 py-2 flex items-center justify-between border-l border-r border-b">
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="search" value="{{ __('Search Resource') }}" />
                            <x-jet-input id="search" placeholder="find resource" type="password" class="text-xs capitalize mt-1 block w-full" wire:model.defer="state.search" autocomplete="current-password" />
                            <x-jet-input-error for="search" class="mt-2" />
                        </div>
                        <button class="text-sm flex items-center font-semibold text-gray-600">
                            <i class="fa fa-bars" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="max-w-lg">
                        @foreach ($list_resource as $rs)
                            <a href="{{route('channel.show', [$channel])}}?rs={{$rs}}" class="block bg-white py-3 border-t">
                                <div class="px-4 py-2 flex  justify-between">
                                    <span class="text-sm font-semibold text-gray-900 capitalize">{{$rs}}</span>
                                    {{-- <span class="text-sm font-semibold text-gray-600">2 days ago</span> --}}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-span-12 px-1 ml-72 mt-0 z-10 bg-white border-l"> 
            <div class="overflow-y-auto h-full bg-gray-100"> 
                <div class="flex flex-col w-full inline-block overflow-y-auto overflow-hidden bg-white">
                      
                    <div class="h-screen">
                        @if(true) 
                            <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
                                <div class="mt-9 flex justify-center">
                                    <img class="w-60"  src="{{url('/assets/img/undraw_choose.svg')}}" />
                                </div>
                                <div class="text-center p-9">
                                    <p class="text-xl">Select Way Resource</p>
                                    <p class="mb-6">Start your campaign and enggangement your customer.</p>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="shadow-lg pt-4 ml-2 mr-2 rounded-lg">
                            <a href="#" class="block bg-white py-3 border-t pb-4">
                                <div class="px-4 py-2 flex  justify-between">
                                    <span class="text-sm font-semibold text-gray-900">Gloria Roberston</span>
                                    <div class="flex">
                                        <span class="px-4 text-sm font-semibold text-gray-600"> yesterday</span>
                                        <img class="h-6 w-6 rounded-full object-cover"
                                            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=144&q=80"
                                            alt="">
                                    </div>
                                </div>
                                <p class="px-4 py-2 text-sm font-semibold text-gray-700"">Lorem mmmmm ipsum dolor sit amet consectetur adipisicing elit. Iusto adipisci laudantium <br> iste delectus explicabo id molestiae cupiditate corrupti distinctio alias. <br> Temporibus quae tenetur quod cupiditate, nostrum tempore inventore maxime ut! </p>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
