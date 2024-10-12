<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @if( Route::currentRouteName() == 'admin.asset' )
            @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
                'menu.admin-menu-asset',
                []
            )
        @else
            @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
                'menu.admin-menu-user',
                []
            )
        @endif
        
        @includeWhen(auth()->user()->isSuper || str_contains(auth()->user()->activeRole->role->name, 'Admin'),
            'menu.admin-menu-user',
            []
        )

        <div class="col-span-12 px-3 lg:ml-24 mt-2">
            <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-auto">
                    <div class="flex gap-3 p-3 justify-between">
                        <div class="p-4 hidden">
                            <form method="GET" action="{{ route('admin.department.get')}}">
                                @csrf
                                <div>
                                    <!-- <x-jet-input name="code" type="text" placeholder="aicsp" /> -->
                                    <input type="text" name="code" list="server" >
                                    <datalist id="server">
                                            @foreach(config('viguard.server') as $key => $server)
                                            <option value="{{$key}}">
                                            @endforeach
                                    </datalist>
                                    <x-jet-button type="submit">
                                        {{ __('Update Department') }}
                                    </x-jet-button>
                                </div>
                            </form>
                        </div>
                        @livewire('department.update')
                        @livewire('department.setting-contact')

                    </div>
                    <div class="m-3">
                        <livewire:table.department-table searchable="source_id, name, ancestors, parent, client_id" exportable />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
