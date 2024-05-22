<div>
    <x-jet-form-section submit="saveUser({{$user->id}})">
        <x-slot name="title">
            {{ __('Delete User Account') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Delete User Account.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-12 sm:col-span-12">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="user_saved">
                {{ __('Profile user saved.') }}
            </x-jet-action-message>

            <x-jet-danger-button wire:click="confirmDelete" wire:loading.attr="disabled" class="p-2">
                {{ __('Delete User') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-form-section>

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

    <x-jet-section-border />

</div>
