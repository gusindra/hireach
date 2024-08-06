<div>
    <x-jet-form-section submit="update">
        <x-slot name="title">
            {{ __('Convert Client To User') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The basic information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model="email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="phone" value="{{ __('Phone') }}" />
                    <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model="phone" />
                    <x-jet-input-error for="phone" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <div class="flex">
                        <x-jet-input id="password" type="text" class="mt-1 block w-full" wire:model="password" />
                        <x-jet-button type="button" class="ml-2" wire:click="generatePassword">
                            {{ __('Generate Password') }}
                        </x-jet-button>
                    </div>
                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    @if (session()->has('message'))
        <div class="mt-4 alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>
