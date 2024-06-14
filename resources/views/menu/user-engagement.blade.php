<aside id="default-sidebar"
    class="dark:text-white w-24 mt-16 col-span-1 left-0 z-30 transition-transform -translate-x-full sm:translate-x-0 fixed overflow-y-auto lg:block inset-0 bg-white"
    aria-label="Sidenav">
    <div
        class="overflow-y-auto py-2 px-2 h-full bg-white dark:bg-slate-800 border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <ul class="space-y-2">
            <li class="text-center flex items-center">
                <a href="{{ route('contact.index') }}" type="button"
                    class="{{ url()->full() == route('contact.index') ? 'bg-slate-100' : '' }} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <span class="text-left whitespace-nowrap text-xs">Contact List</span>
                    </center>
                </a>
            </li>
            <li class="text-center flex items-center">
                <a href="{{ route('resources.index') }}?resource=1" type="button"
                    class="{{ request()->get('resource') == 1 ? 'bg-slate-100' : '' }} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>

                        <span class="text-left whitespace-nowrap text-xs">One Way</span>
                    </center>
                </a>
            </li>
            <li class="text-center flex items-center">
                <a href="{{ route('resources.index') }}?resource=2" type="button"
                    class="{{ request()->get('resource') == 2 ? 'bg-slate-100' : '' }} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                        <span class="text-left whitespace-nowrap text-xs">Two Way</span>
                    </center>
                </a>
            </li>

            <li class="text-center flex items-center">
                <a href="{{ route('message') }}" type="button"
                    class="{{ url()->full() == route('message') ? 'bg-slate-100' : '' }} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>

                        <span class="text-left whitespace-nowrap text-xs">Live Chat</span>
                    </center>
                </a>
            </li>

            <li class="text-center flex items-center">
                <a href="{{ route('campaign.index') }}" type="button"
                    class="{{ url()->full() == route('campaign.index') ? 'bg-slate-100' : '' }} items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600 dark:bg-slate-600"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>


                        <span class="text-left whitespace-nowrap text-xs">Campaign</span>
                    </center>
                </a>
            </li>
        </ul>
        <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700 hidden">
            <li class="text-center flex items-center">
                <button type="button"
                    class="items-center p-2 w-full text-base font-normal text-gray-600 rounded-lg transition duration-75 group hover:bg-gray-100 dark:text-white dark:hover:bg-slate-700 dark:bg-slate-600"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <center>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </center>
                    <span class="text-left whitespace-nowrap text-xs">More</span>
                </button>
            </li>
        </ul>
    </div>
    @include( 'menu.setting-menu',  ['user' => auth()->user()] )

</aside>
