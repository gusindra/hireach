<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
            'menu.admin-menu-user',
            []
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <a href="{{ route('admin.contact-duplicate') }}"
                        class="inline-block px-6 py-3 bg-blue-500 text-white font-semibold text-sm rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition">
                        Resolve Duplicate
                    </a>

                </div>
                <div class="m-3">
                    <livewire:table.user-contact-all-table exportable />
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
