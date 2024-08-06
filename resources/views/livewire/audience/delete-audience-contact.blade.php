<div>

    <x-jet-button class="bg-gray-600" wire:click="actionShowDeleteModal">
        {{ __('Delete') }}
    </x-jet-button>
    <x-jet-dialog-modal class="text-left" wire:model="modalDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Audience Contact') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('Are you sure you want to delete this audienceClients?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete({{ $audienceClient }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>


</div>
