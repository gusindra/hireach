<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="grid grid-cols-12">
        
        @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin', 'menu.admin-menu', [])

        <div class="col-span-12 px-3 ml-24 mt-2"> 
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container mx-auto">
                    <div class="flex justify-between">
                        <div class="p-4">
                            @livewire('user.add')
                        </div>
                    </div>
                    <div>
                        <livewire:table.users-table searchable="name, email, gender" exportable />
                        {{-- <livewire:table.client-datatables searchable="name, email, gender" exportable /> --}}
                        {{-- <livewire:table.team-table searchable="name, email, gender" exportable /> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
