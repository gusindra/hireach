<div>

    @if ($notification->status != 'deleted')
        <x-link-button class="bg-red-500 p-2 px-4 text-white uppercase hover:bg-red-300 hover:text-white" wire:click="actionShowDeleteModal">
            {{ __('Delete ') }}
        </x-link-button>
    @else
        <x-jet-button disabled class="bg-red-600 text-white uppercase px-2" wire:click="actionShowDeleteModal">
            {{ __('Delete ') }}
        </x-jet-button>
    @endif
    <x-jet-dialog-modal class="text-left" wire:model="modalDeleteVisible">
        <x-slot name="title">
            {{ __('Delete ') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('Are you sure you want to delete this ?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete({{ $notification }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>


</div>
