<div>

    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-medium text-gray-900">{{ __('Delete  Details') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ __('Delete User Account') }}</p>
        </div>
        <div class="ml-4">
            <x-jet-danger-button wire:click="confirmDelete" wire:loading.attr="disabled" class="p-2">
                {{ __('Delete User') }}
            </x-jet-danger-button>
        </div>
    </div>


    <x-jet-dialog-modal wire:model="modalDeleteVisible">
        <x-slot name="title">
            <span class="text-red-600">{{ __('Are You Sure?') }}</span>
        </x-slot>

        <x-slot name="content">
            @if ($user)
                <p class="text-gray-600">
                    Do you really want to delete the user named
                    <strong>{{ __(' `:name` ', ['name' => $user->name]) }}</strong> ?
                </p>
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
