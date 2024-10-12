<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu-setting',
            []
        )
        <div class="col-span-12 px-3 lg:ml-24 mt-2  mb-14">
            <div class=""> 
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
