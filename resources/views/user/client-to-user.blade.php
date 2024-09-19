<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-12">

        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
        'menu.admin-menu-user-profile',
        []
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <header class="bg-white dark:bg-slate-900 flex">

                <ul
                    class="flex gap-1 flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <li class="me-2">
                        <a href="{{ route('user.show.request', $user->id) }}" aria-current="page"
                            class="inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500">Message Request</a>
                    </li>
                    <li class="me-2">
                        <a href="{{ route('user.show.client', $user->id) }}"
                            class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">Contact</a>
                    </li>
                </ul>

            </header>
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-4">
                    @livewire('contact.add', ['client_id'=>$user->id])
                </div>

                <div class="mx-auto">
                    @livewire('table.client-to-user', ['user' => $user])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
