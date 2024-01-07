<x-app-layout>
    <x-slot name="header"></x-slot>
    @if(request()->routeIs('commercial'))
        @include('assistant.nav')
    @endif

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-sm my-2">
                <div class="mx-auto">
                    <div class="m-4 inline-flex cursor-pointer items-center px-2 py-1 bg-green-800 border border-transparent rounded-md font-normal text-xs text-white 1g-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">
                        @livewire('project.add')
                    </div>
                    <div class="px-4 py-2">
                        <livewire:table.project-table searchable="name" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
