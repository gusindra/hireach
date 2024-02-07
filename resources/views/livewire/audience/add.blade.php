<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{__('Add Audience')}}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Audience') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="input.name" value="{{ __('Name') }}" />
                <x-jet-input autocomplete="off" id="input.name" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="input.name" autofocus />
                <x-jet-input-error for="input.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="input.description" value="{{ __('Description') }}" />
                <x-jet-input autocomplete="off" id="input.description" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="input.description" autofocus />
                <x-jet-input-error for="input.description" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

