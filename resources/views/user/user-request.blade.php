<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-12">

        @includeWhen(auth()->user()->isSuper || (auth()->user()->team && auth()->user()->team->role == 'superadmin'),
            'menu.admin-menu-user-profile',
            []
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div>
                        <h3>Inbounce</h3>
                        <livewire:table.in-bound-table :filterMonth="$filterMonth" :userId="$user->id" searchable="name, description" exportable />
                    </div>
                    <div>
                        <h3>Outbounce</h3>
                        <livewire:table.out-bound-table :filterMonth="$filterMonth" :userId="$user->id" searchable="name, description" exportable />
                    </div>
                    <div>
                        <h3>SMS Blast</h3>
                        <livewire:table.sms-blast-table :filterMonth="$filterMonth" :userId="$user->id" searchable="name, description" exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
