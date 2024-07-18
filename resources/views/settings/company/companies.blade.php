<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && auth()->user()->team->role == 'superadmin'),
            'menu.admin-menu-setting',
            []
        )
        <div class="col-span-12 px-3 lg:ml-24 mt-2 space-y-6">
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

            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="">
                        @livewire('setting.general.product-line.add')
                    </div>
                    <div class="p-4">
                        <livewire:table.product-line-table searchable="name" />
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="">
                        @livewire('setting.general.commerce-item.add')
                    </div>
                    <div class="p-4">
                        <livewire:table.commerce-item searchable="name" />
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="">
                        @livewire('setting.add')
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
