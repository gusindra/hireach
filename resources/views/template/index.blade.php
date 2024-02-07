<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Template') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-content', [])

        <div class="col-span-12 px-6 ml-24 mt-2">
            <div class="mx-auto">
                @if (auth()->user()->currentTeam->id != 1 )
                <div class="flex gap-3 py-4">
                    @livewire('template.templates')
                    {{-- <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition {{!request()->get('resource')?'bg-yellow-500':''}}" href="{{route('template')}}">All</a>
                    <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition {{request()->get('resource')==1?'bg-yellow-500':''}}" href="{{route('template')}}?resource=1">1Way</a>
                    <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition {{request()->get('resource')==2?'bg-yellow-500':''}}" href="{{route('template')}}?resource=2">2Way</a>
                    <a class="inline-flex items-center bg-gray-800 border border-transparent rounded-md h-8 p-4 mt-4 font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" href="{{route('view.template')}}">View Tree</a> --}}
                </div>
                @endif

                <div class="py-3">
                    <div class="z-10">
                        <livewire:table.templates-table searchable="name, description" resource="{{request ()->get('resource')}}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
