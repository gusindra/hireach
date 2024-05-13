<x-app-layout>
    <x-slot name="header"></x-slot>


    @include('settings.navigation', ['page'=>$page])

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.admin-menu-setting', [])

        <div class="col-span-12 px-6 ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto">
                    @livewire('setting.company-add')
                    <div class="px-4 py-2">
                        <livewire:table.companies searchable="name" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
