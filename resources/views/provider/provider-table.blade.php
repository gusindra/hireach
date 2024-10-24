<x-app-layout>
    <x-slot name="header"></x-slot>
    <div class="hidden">
        @include('settings.navigation')
    </div>

    <div class="grid grid-cols-12">

        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu',
            []
        )

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="flex justify-between flex-row-reverse">
                        <div class="px-4 pt-4">
                            @livewire('provider.add')
                        </div>
                    </div>
                    <div class="px-4 py-1">
                        <livewire:table.provider-table  searchable="name" />

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
