<div>
    @if ($notification->status != 'deleted')
        <x-link-button class="text-blue-700" wire:click="showDeleteModal({{ $notification->id }})">
            {{ __('Delete ') }}
        </x-link-button>
    @else
        <x-jet-button disabled class=" text-blue-300 px-2">
            {{ __('Delete ') }}
        </x-jet-button>
    @endif

    <x-jet-dialog-modal class="text-left" wire:model="modalDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Notification') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('Are you sure you want to delete this notification? Once deleted, it cannot be undone.') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteNotification" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
