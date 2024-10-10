<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
            'menu.admin-menu-user-profile',
            []
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="flex gap-4 m-3">
                        @livewire('department.setting-contact')
                    </div>
                    <div class="m-3">
                        <livewire:table.department-user-table :departmentId="$department->id" :userId="$user->id" searchable="source_id, name, ancestors, parent, client_id" exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
