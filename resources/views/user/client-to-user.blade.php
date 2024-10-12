<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-12">

        @if( Route::currentRouteName() == 'admin.asset' )
            @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
                'menu.admin-menu-asset',
                []
            )
        @else
            @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
                'menu.admin-menu-user',
                []
            )
        @endif

        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu-user-profile',
            ['user' => $user]
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <header class="bg-white dark:bg-slate-900 flex">
                
                <ul
                    class="flex gap-1 flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    
                    <li class="text-center flex items-center">
                        <a href="{{ route('user.show.request', $user->id) }}" type="button"
                            class="{{ url()->full() == route('user.show.client', $user->id) ? 'bg-slate-300' : 'bg-slate-50' }} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600"
                            aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                            <center> 
                                <span class="text-left whitespace-nowrap text-xs">Message Request</span>
                            </center>
                        </a>
                    </li>
                    <li class="text-center flex items-center">
                        <a href="{{ route('user.show.client', $user->id) }}" type="button"
                            class="{{ strpos( url()->full(), 'order' ) !== false ? 'bg-slate-300' : 'bg-slate-50' }} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600"
                            aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                            <center>
                                <span class="text-left whitespace-nowrap text-xs">Contact Consumer</span>
                            </center>
                        </a>
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
