<div class="flex flex-row-reverse">
    <x-link-button :disabled="!userAccess('PERMISSION', 'delete')" class="text-red-400 hover:text-red-600" wire:click="actionShowDeleteModal">
        {{ __('Delete Permissions') }}
    </x-link-button>
    <x-jet-dialog-modal class="text-left" wire:model="modalDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Permissions') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('Are you sure you want to delete this Permissions?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete({{ $permission }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>


</div>
