<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing Detail') }}
        </h2>
    </x-slot>

    <header class="bg-white dark:bg-slate-900 dark:border-slate-600 border-b shadow"> </header>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user()->isSuper ||
                (auth()->user()->team && str_contains(auth()->user()->activeRole->role->name, 'Admin')),
            'menu.admin-menu',
            []
        )
        <div class="col-span-12 px-3 ml-24 mt-2">

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
