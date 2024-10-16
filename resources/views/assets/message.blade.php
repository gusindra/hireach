<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
            'menu.admin-menu-asset',
            []
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">

                <div class="m-3">


                    <livewire:assets.message-table />


                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
