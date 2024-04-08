<div>
    <x-jet-dialog-modal wire:model="modalDeleteVisible">
        <x-slot name="title">
            <span class="text-red-600">{{ __('Are You Sure?') }}</span>
        </x-slot>

        <x-slot name="content">
            @if ($contact)
                <p class="text-gray-600">
                    {{ __('Do you really want to delete the contact named :name?', ['name' => $contact->name]) }}</p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('modalDeleteVisible', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Yes, Delete It') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
