<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing Detail') }}
        </h2>
    </x-slot>

    <header class="bg-white dark:bg-slate-900 dark:border-slate-600 border-b shadow"></header>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper ||
                    (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
                    'menu.admin-menu',
                    []
        )
        <div class="col-span-12 px-3 ml-24 mt-2">

            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="p-4">

                        <!-- User Contact Table Section -->
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                            {{ __('User Contacts') }}
                        </h3>
                        <livewire:table.user-contact-all-table per-page="20" exportable />

                        <!-- Messages Table Section -->
                        <h3 class="text-lg font-semibold mt-8 mb-4 text-gray-800 dark:text-gray-200">
                            {{ __('Messages') }}
                        </h3>
                        <livewire:assets.message-table />

                        <!-- Asset Templates Table Section -->
                        <h3 class="text-lg font-semibold mt-8 mb-4 text-gray-800 dark:text-gray-200">
                            {{ __('Asset Templates') }}
                        </h3>
                        <livewire:table.asset-templates-table exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
