<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu-setting',
            []
        )
        <div class="col-span-12 px-3 lg:ml-24 mt-2  mb-14">
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-3 space-y-6">
                    <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-md sm:rounded-lg">
                        <div class="mx-auto">
                            <div class="">
                                @livewire('setting.company-add')
                            </div>
                            <div class="p-4">
                                <livewire:table.companies searchable="name" hide-pagination />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-md sm:rounded-lg">
                        <div class="mx-auto">
                            <div class="">
                                @livewire('setting.general.product-line.add')
                            </div>
                            <div class="p-4">
                                <livewire:table.product-line-table searchable="name" hide-pagination />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-md sm:rounded-lg">
                        <div class="mx-auto">
                            <div class="">
                                @livewire('setting.general.commerce-item.add')
                            </div>
                            <div class="p-4">
                                <livewire:table.commerce-item searchable="name" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-600  overflow-hidden sm:rounded-lg">
                    <div class="mx-auto">
                        <div class="">
                            @livewire('setting.add')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
