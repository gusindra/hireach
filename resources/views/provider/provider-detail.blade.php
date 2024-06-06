<x-app-layout>
    <header class="bg-white dark:bg-slate-900 dark:border-slate-600 border-b shadow">
        <div class="flex justify-between pt-2 max-w-9xl mx-auto px-4 sm:px-6 lg:ml-24">
            <div class="justify-end flex">
                <div class="items-center justify-end px-2 mb-3">
                    <div class="space-x-1 sm:-my-px">
                        <x-jet-nav-link href="{{ route('settings.show', 'company') }}">
                            {{ __('Provider') }}
                        </x-jet-nav-link>
                        <span class="inline-flex items-center px-1 pt-1 text-xs font-medium leading-5 text-gray-900 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <x-jet-nav-link href="#" :active="true">
                            {{ $provider->name }}
                        </x-jet-nav-link>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @includeWhen(auth()->user()->isSuper || (auth()->user()->team && auth()->user()->team->role == 'superadmin'),
        'menu.admin-menu-setting',
        []
    )
    <div class="col-span-12 px-3 lg:ml-24 mt-2">
        <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto">
                <div class="p-4">
                    @livewire('provider.edit', ['uuid' => $provider->id])
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
