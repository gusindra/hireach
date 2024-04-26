<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Template') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-content', [])
        <div class="col-span-12 px-6 ml-24 mt-2">
            @if (request()->get('resource') == 1)
                @livewire('template.one-way')
            @endif
            @if (request()->get('resource') == 2)
                @livewire('template.two-way')
            @endif
            @if (request()->get('type') == 'helper')
                @livewire('template.helper')
            @endif
            <div class="mx-auto">

                <header class="bg-white dark:bg-slate-900 flex">

                    <ul
                        class="flex gap-1 flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                        <li class="me-2">
                            <a href="{{ route('template') }}" aria-current="page"
                                class="inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">All</a>
                        </li>
                        <li class="me-2">
                            <a href="{{ route('view.template') }}"
                                class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Tree
                                View</a>
                        </li>
                    </ul>

                </header>
                <div class="py-3">
                    <div class="z-10">
                        <livewire:table.templates-table searchable="name, description"
                            resource="{{ request()->get('resource') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
