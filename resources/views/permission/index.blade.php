<x-app-layout>
    <x-slot name="header"></x-slot>
    <div class="hidden">
        @include('settings.navigation', ['page' => $page])
    </div>
    <div class="grid grid-cols-12">

        @includeWhen(auth()->user()->isSuper ||
                (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu',
            []
        )

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="flex flex-row-reverse">
                        @livewire('permission.add')
                    </div>
                    <!-- <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 right-5 mr-0">
                        <x-jet-button>
                            {{ __('Add New Role') }}
                        </x-jet-button>
                    </div> -->
                    <div class="px-4 py-2">
                        <livewire:table.permission searchable="model" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
