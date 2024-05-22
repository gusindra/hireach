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
                    @livewire('user.profile', ['user' => $user])
                    @livewire('user.delete', ['userId' => $user->id])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
