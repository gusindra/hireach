<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && auth()->user()->team->role == 'superadmin'),
            'menu.admin-menu-setting',
            []
        )
        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="">
                        @livewire('setting.company-add')
                    </div>
                    <div class="p-4">
                        <livewire:table.companies searchable="name" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
