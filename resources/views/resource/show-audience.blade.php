<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Audience') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-engagement', [])

        <div class="col-span-12 px-2 ml-24 mt-2">
            <header class="bg-white dark:bg-slate-900 flex">

                <ul
                    class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <li class="me-2">
                        <a href="{{ route('contact.index') }}"
                            class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Contact</a>
                    </li>
                    <li class="me-2">
                        <a href="{{ route('audience.index') }}" aria-current="page"
                            class="inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Audience</a>
                    </li>
                </ul>

            </header>
            <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-b-lg border-t space-y-2">
                @livewire('audience.edit', ['user' => $audience])
            </div>
        </div>
    </div>
</x-app-layout>
