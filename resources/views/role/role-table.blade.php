<x-app-layout>
    <x-slot name="header"></x-slot>
    <div class="hidden">
        @include('settings.navigation')
    </div>

    <div class="grid grid-cols-12">

        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu-setting',
            []
        )

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="flex justify-between">
                        <div>
                            @livewire('role.roles')
                        </div>
                    </div>
                    <!-- <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6 right-5 mr-0">
                        <x-jet-button>
                            {{__('Add New Role')}}
                        </x-jet-button>
                    </div> -->
                    <div class="px-4 py-2">
                        <livewire:table.roles-table searchable="name" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
