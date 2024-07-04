<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Topup Detail') }}
        </h2>
    </x-slot>
    <!-- Topup Dashboard -->
    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-balance', [])

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-2 bg-white dark:bg-slate-600 border border-gray-200">
                    <div class="mt-2 text-2xl">
                        Quotation
                    </div>
                </div>

                <div class="py-3 px-1">
                    @livewire('table.quotation')
                </div>
            </div>
        </div>

        <x-jet-section-border />
</x-app-layout>
