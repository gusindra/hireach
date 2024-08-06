<aside id="default-sidebar" class="dark:text-white w-24 mt-16 col-span-1 left-0 z-30 transition-transform -translate-x-full sm:translate-x-0 fixed overflow-y-auto lg:block inset-0 bg-white" aria-label="Sidenav">
    <div class="overflow-y-auto py-2 px-2 h-full bg-white dark:bg-slate-800 border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <ul class="space-y-2">
            <li class="text-center flex items-center">
                <a href="{{ route('profile.show') }}" type="button" class="{{url()->full()==route('profile.show')?'bg-slate-100':''}} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="text-left whitespace-nowrap text-xs">Profile</span>
                    </center>
                </a>
            </li>
            <li class="text-center flex items-center">
                <a href="{{ route('api-tokens.index') }}" type="button" class="{{url()->full()==route('api-tokens.index')?'bg-slate-100':''}} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
                        </svg>

                        <span class="text-left whitespace-nowrap text-xs">API Token</span>
                    </center>
                </a>
            </li>
            <li class="text-center flex items-center">
                <a href="{{route('teams')}}" type="button" class="{{url()->full()==route('teams')?'bg-slate-100':''}} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <span class="text-left whitespace-nowrap text-xs">Team</span>
                    </center>
                </a>
            </li>
        </ul>
        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700 hidden">
            <li class="text-center flex items-center">
                <button type="button" class="items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600" aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
</svg>

                    </center>
                    <span class="text-left whitespace-nowrap text-xs">More</span>
                </button>
            </li>
        </ul>
    </div>
    @include( 'menu.setting-menu',  ['user' => auth()->user()] )

</aside>
