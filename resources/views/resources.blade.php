<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resource') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                @if (auth()->user()->currentTeam->id != 1 )
                    <div class="flex gap-3 px-2 pb-3">
                        @if(request ()->get('resource')==1)
                        <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" href="{{route('resources')}}">Send 1 Way Resource</a>
                        @elseif(request ()->get('resource')==2)
                        <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" href="{{route('resources')}}">Send 2 Way Resource</a>
                        @endif
                        <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition {{request ()->get('resource')==1?'bg-yellow-500':''}}" href="{{route('resources')}}?resource=1">1Way</a>
                        <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition {{request ()->get('resource')==2?'bg-yellow-500':''}}" href="{{route('resources')}}?resource=2">2Way</a>
                    </div>
                @endif
                <div class="m-2">
                    @if(request ()->get('resource')==1)
                    <livewire:table.requests-table searchable="name, description" resource="{{request ()->get('resource')}}" />
                    @elseif(request ()->get('resource')==2)
                    <livewire:table.sms-blast-table searchable="name, description" resource="{{request ()->get('resource')}}" />
                    @else
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
