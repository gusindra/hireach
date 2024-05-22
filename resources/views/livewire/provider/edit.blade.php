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



    <div class="grid ml-5 grid-cols-2 gap-4 mt-6 shadow p-4">
        <div class="">
            <h2 class="text-lg">Delete Provider</h2>
            <p class="mt-2 text-sm text-gray-600">This is for delete providers</p>
        </div>

        <div class="text-right ">

            <div class="p-4">
                <div class="flex items-center justify-end">
                    <x-jet-button wire:click="actionShowDeleteModal">
                        {{ __('Delete Provider') }}
                    </x-jet-button>
                </div>


            </div>
        </div>
    </div>
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
