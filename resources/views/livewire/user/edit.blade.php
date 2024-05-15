<div>
    <div>
        <x-jet-form-section submit="updateUser({{ $user->id }})">
            <x-slot name="title">
                {{ __('Edit User') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Edit the user details') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-3">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="inputuser.name"
                            wire:model.defer="inputuser.name" wire:model.debounce.800ms="inputuser.name" />
                        <x-jet-input-error for="inputuser.name" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" type="text" class="mt-1 block w-full"
                            wire:model="inputuser.email" wire:model.defer="inputuser.email"
                            wire:model.debounce.800ms="inputuser.email" />
                        <x-jet-input-error for="inputuser.email" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="nick" value="{{ __('Nick') }}" />
                        <x-jet-input id="nick" type="text" class="mt-1 block w-full" wire:model="inputuser.nick"
                            wire:model.defer="inputuser.nick" wire:model.debounce.800ms="inputuser.nick" />
                        <x-jet-input-error for="inputuser.nick" class="mt-2" />
                    </div>
                </div>


                <div class="col-span-6 sm:col-span-3">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="phone_no" value="{{ __('Phone No') }}" />
                        <x-jet-input id="phone_no" type="text" class="mt-1 block w-full"
                            wire:model="inputuser.phone_no" wire:model.defer="inputuser.phone_no"
                            wire:model.debounce.800ms="inputuser.phone_no" />
                        <x-jet-input-error for="inputuser.phone_no" class="mt-2" />
                    </div>
                </div>

            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message on="userSaved">
                    {{ __('User data updated.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Update') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>
</div>
