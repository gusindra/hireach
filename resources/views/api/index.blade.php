<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('API Tokens') }}
        </h2>
    </x-slot>


    @includeWhen(auth()->user(),
        'menu.user-setting',
        []
    )
    <div class="col-span-12 px-3 lg:ml-24 mt-2">
        <div class="bg-white dark:bg-slate-600  overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto">
                <div class="p-4">
                    <div>
                        <div class="max-w-9xl mx-auto py-10 sm:px-6 lg:px-8">
                            @livewire('api.api-token-manager')
                        </div>
                    </div>

                    <div>
                        <div class="max-w-9xl mx-auto py-10 sm:px-6 lg:px-8">
                            @livewire('api.webhook-manager')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12">


    </div>
</x-app-layout>
