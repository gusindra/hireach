<div>
    <x-jet-section-border />

    <x-jet-form-section submit="saveUser({{ $user->id }})">
        <x-slot name="title">
            {{ __('Audience Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update Audience profile information and email address.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Name -->
            <div class="col-span-3">
                <x-jet-label for="inputuser.name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="inputuser.name" />
                <x-jet-input-error for="inputuser.name" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="inputuser.description" value="{{ __('Description') }}" />
                <x-jet-input id="description" type="text" class="mt-1 block w-full"
                    wire:model.defer="inputuser.description" />
                <x-jet-input-error for="inputuser.description" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="audience_saved">
                {{ __('Profile user saved.') }}
            </x-jet-action-message>

            <x-save-button show="true">
                {{ __('Save') }}
            </x-save-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    @livewire('audience.add-contact', ['audience' => $user])

    <x-jet-section-border />

    <x-jet-form-section submit="delete">
        <x-slot name="title">
            {{ __('Delete Audience') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Permanently delete your account.') }}
        </x-slot>

        <x-slot name="form">

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="client_saved">
                {{ __('Client data saved.') }}
            </x-jet-action-message>

            @if ($user)
                <x-jet-danger-button wire:click="$emitTo('audience.delete', 'confirmDelete', {{ $user->id }})">
                    {{ __('Delete Audience') }}
                </x-jet-danger-button>

                <livewire:audience.delete :audience="$user" :key="$user->id" />
            @endif
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />
</div>
