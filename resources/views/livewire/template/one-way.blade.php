<div>
    <div class="flex items-center">
        <x-jet-button wire:click="actionShowModalOneWay">
            {{ __('Add One Way') }}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Action') }}
        </x-slot>

        <x-slot name="content">
            <input type="hidden" name="way" id="way" value="1">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="name" value="{{ __('Template Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name"
                    autofocus />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="description"
                    autofocus />
                <x-jet-input-error for="description" class="mt-2" />
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
