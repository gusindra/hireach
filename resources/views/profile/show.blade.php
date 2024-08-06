<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
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
                    <div class="max-w-9xl mx-auto py-10 sm:px-6 lg:px-8">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.update-profile-information-form')

                            <x-jet-section-border />
                        @endif

                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                            <div class="mt-10 sm:mt-0">
                                {{-- @livewire('profile.update-password-form') --}}
                            </div>

                            <x-jet-section-border />
                        @endif

                        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.two-factor-authentication-form')
                            </div>

                            <x-jet-section-border />
                        @endif

                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.logout-other-browser-sessions-form')
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                            <x-jet-section-border />

                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.delete-user-form')
                            </div>
                        @endif

                        <x-jet-section-border />
                        @livewire('setting.dark-mode')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12">


    </div>
</x-app-layout>
