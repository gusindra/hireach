<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Template') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-content', [])
        <div class="col-span-12 px-6 ml-24 mt-2">
            @if (request()->get('resource') == 1)
                @livewire('template.one-way')
            @endif
            @if (request()->get('resource') == 2)
                @livewire('template.two-way')
            @endif
            @if (request()->get('type') == 'helper')
                @livewire('template.helper')
            @endif
            <div class="mx-auto">
                <div class="py-3">
                    <div class="z-10">
                        <livewire:table.templates-table searchable="name, description"
                            resource="{{ request()->get('resource') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
