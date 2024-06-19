<div>
    <x-jet-form-section submit="delete">
        <x-slot name="title">
            {{ __('Delete Campaign') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Are you sure you want to delete this campaign? This action cannot be undone.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Empty form slot to maintain layout consistency -->
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="deleted">
                {{ __('Campaign deleted.') }}
            </x-jet-action-message>

            <x-jet-danger-button wire:click="$set('showModal', true)">
                {{ __('Delete Campaign') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-form-section>

    <!-- Delete Confirmation Modal -->
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Delete Campaign') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this campaign? This action cannot be undone.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
