<div class="dark:text-white w-auto mt-2 ml-28 col-span-12 lg:block bg-white">
    <div class="pt-2 h-full bg-white dark:bg-slate-800 border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">        
        <header class="bg-white dark:bg-slate-900 flex">
            <ul class="flex gap-1 flex-wrap text-sm font-medium text-center text-gray-500 dark:border-gray-700 dark:text-gray-400">
                
                @foreach (config('menu.list.subnavigation.admin.admin-user') as $menu)
                    <li class="me-2"> 
                        <a href="{{ route($menu['url']) }}" type="button"
                            class="{{ url()->full() != route($menu['url']) ? 'bg-slate-100 text-slate-800' : 'border-l border-r border-t border-gray-100 hover:bg-slate-100' }} inline-block py-3 px-4 rounded-t-lg hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300"
                            aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                            <center> 
                                <span class="text-left whitespace-nowrap text-xs">{{$menu['title']}}</span></span>
                            </center>
                        </a>
                    </li>
                @endforeach
            </ul>
        </header>
    </div>
</div>
