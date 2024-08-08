<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Company Detail') }}
        </h2>
    </x-slot>

    <header class="bg-white dark:bg-slate-900 dark:border-slate-600 border-b shadow">
        <div class="flex justify-between pt-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 lg:ml-20">
            <div class="justify-end flex">
                <div class="items-center justify-end px-2 mb-3">

                </div>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper ||
                (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu-setting',
            []
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="p-4">
                        <div class="my-2">
                            <a href="{{route('settings.log.export')}}?action=clear" class="bg-red-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">Clear & Export</a>
                            <a href="{{route('settings.log.export')}}" class="bg-slate-600 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" >Export</a>
                        </div>
                        <livewire:table.log-change-table searchable="model,model_id,remark,before" exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
