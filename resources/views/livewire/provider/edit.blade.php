<div>
    <x-jet-form-section submit="update({{ $provider->id }})">
        <x-slot name="title">
            {{ __('Provider') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The Provider`s information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 grid grid-cols-2">
                <!-- Provider Code -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="code" value="{{ __('Code') }}" />
                    <x-jet-input id="code" type="text" class="mt-1 block w-full" wire:model="code"
                        wire:model.defer="code" wire:model.debunce.800ms="code" />
                    <x-jet-input-error for="code" class="mt-2" />
                </div>
            </div>


            <div class="col-span-6 grid grid-cols-2">
                <!-- Provider Name -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name"
                        wire:model.defer="name" wire:model.debunce.800ms="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 grid grid-cols-2">
                <!-- Provider Company -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="company" value="{{ __('Company') }}" />
                    <x-jet-input id="company" type="text" class="mt-1 block w-full" wire:model="company"
                        wire:model.defer="company" wire:model.debunce.800ms="company" />
                    <x-jet-input-error for="company" class="mt-2" />
                </div>
            </div>


            <div class="col-span-6 grid grid-cols-2">
                <!-- Provider Channel -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="channel" :value="__('Channel')" />
                    <x-jet-input id="channel" type="text" class="mt-1 block w-full" wire:model="channel"
                        wire:model.defer="channel" wire:model.debunce.800ms="channel" />
                    <x-jet-input-error for="channel" class="mt-2" />
                </div>
            </div>



        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Provider  Updated.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="actionShowDeleteModal">
        <x-slot name="title">
            {{ __('Delete Provider') }}
        </x-slot>

        <x-slot name="description">
            {{ __('This is for delete Provider.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 mx-4 text-right">
                </div>
                <div class="col-span-12 sm:col-span-1 mx-4 text-right">
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Provider saved.') }}
            </x-jet-action-message>

            <x-jet-button class="bg-red-600" wire:click="actionShowDeleteModal">
                {{ __('Delete Provider') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-dialog-modal class="text-left" wire:model="modalDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Provider') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('Are you sure you want to delete this provider?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
