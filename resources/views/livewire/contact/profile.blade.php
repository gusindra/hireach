<div>
    <x-jet-form-section submit="saveUser({{ $user->id }})">
        <x-slot name="title">
            {{ __('User Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update user profile information and email address.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">

                <label class="block font-medium text-sm text-gray-700 dark:text-slate-300" for="photo">
                    Photo
                </label>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}&amp;color=7F9CF5&amp;background=EBF4FF"
                        alt="Admin" class="rounded-full h-20 w-20 object-cover">
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <select name="title" id="title"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="inputuser.title">
                        <option {{ $user->title == 'Mr.' ? 'selected' : '' }} value="Mr.">Mr.</option>
                        <option {{ $user->title == 'Mrs.' ? 'selected' : '' }} value="Mrs.">Mrs.</option>
                        <option {{ $user->title == 'Miss' ? 'selected' : '' }} value="Miss">Miss</option>
                        <option {{ $user->title == 'Ms.' ? 'selected' : '' }} value="Ms.">Ms.</option>
                        <option {{ $user->title == 'PT.' ? 'selected' : '' }} value="PT.">PT.</option>
                        <option {{ $user->title == 'CV.' ? 'selected' : '' }} value="CV.">CV.</option>
                        <option {{ $user->title == 'none' ? 'selected' : '' }} value="none">None</option>
                    </select>
                    <x-jet-input-error for="title" class="mt-2" />
                </div>
            </div>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="inputuser.name"
                        wire:model.defer="inputuser.name" wire:model.debunce.800ms="inputuser.name" />
                    <x-jet-input-error for="inputuser.name" class="mt-2" />
                </div>
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" type="text" class="mt-1 block w-full" wire:model="inputuser.email"
                        wire:model.defer="inputuser.email" wire:model.debunce.800ms="inputuser.email" />
                    <x-jet-input-error for="inputuser.email" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.phone" value="{{ __('Phone') }}" />
                    <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model="inputuser.phone"
                        wire:model.defer="inputuser.phone" wire:model.debunce.800ms="inputuser.phone" />
                    <x-jet-input-error for="inputuser.phone" class="mt-2" />
                </div>
            </div>

        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="user_saved">
                {{ __('Profile user saved.') }}
            </x-jet-action-message>

            <x-save-button show="{{ $user->status == 'draft' ? 'true' : 'false' }}">
                {{ __('Save') }}
                </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="saveUser({{ $user->id }})">
        <x-slot name="title">
            {{ __('Update Client') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update user client information and billing address.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.sender" value="{{ __('Sender') }}" />
                    <x-jet-input id="sender" type="text" class="mt-1 block w-full" wire:model="inputuser.sender"
                        wire:model.defer="inputuser.sender" wire:model.debunce.800ms="inputuser.sender" />
                    <x-jet-input-error for="inputuser.sender" class="mt-2" />
                </div>
            </div>
            <!-- Identity -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.identity" value="{{ __('Identity') }}" />
                    <x-jet-input id="identity" type="text" class="mt-1 block w-full" wire:model="inputuser.identity"
                        wire:model.defer="inputuser.identity" wire:model.debunce.800ms="inputuser.identity" />
                    <x-jet-input-error for="inputuser.identity" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.tag" value="{{ __('Tag') }}" />
                    <x-jet-input id="tag" type="text" class="mt-1 block w-full" wire:model="inputuser.tag"
                        wire:model.defer="inputuser.tag" wire:model.debunce.800ms="inputuser.tag" />
                    <x-jet-input-error for="inputuser.tag" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.source" value="{{ __('Source') }}" />
                    <x-jet-input id="source" type="text" class="mt-1 block w-full"
                        wire:model="inputuser.source" wire:model.defer="inputuser.source"
                        wire:model.debunce.800ms="inputuser.source" />
                    <x-jet-input-error for="inputuser.source" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-6">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.address" value="{{ __('Address') }}" />
                    <x-jet-input id="address" type="text" class="mt-1 block w-full"
                        wire:model="inputuser.address" wire:model.defer="inputuser.address"
                        wire:model.debunce.800ms="inputclient.address" />
                    <x-jet-input-error for="inputclient.address" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6   sm:col-span-6">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.note" value="{{ __('Notes') }}" />
                    <x-jet-input id="note" type="text" class="mt-1 block w-full" wire:model="inputuser.note"
                        wire:model.defer="inputuser.note" wire:model.debunce.800ms="inputuser.note" />
                    <x-jet-input-error for="inputuser.note" class="mt-2" />
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="client_saved">
                {{ __('Client data saved.') }}
            </x-jet-action-message>

            <x-save-button show="{{ $user->status == 'draft' ? 'true' : 'false' }}">
                {{ __('Save') }}
                </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    @if($user->theUser->department)
    <livewire:contact.department :client="$user" />
    <x-jet-section-border />
    @endif

    @if ($user)
        <x-jet-form-section submit="delete">
            <x-slot name="title">
                {{ __('Delete Contact') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Permanently delete your account.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-12">
                    <div class="text-sm text-gray-600 dark:text-slate-300">
                        Once your data contact is deleted, all of its resources and data will be permanently deleted.
                        Before deleting your data contact, please download any data or information that you wish to
                        retain.
                    </div>
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="client_saved">
                    {{ __('Client data saved.') }}
                </x-jet-action-message>

                <div>
                    <x-jet-danger-button wire:click="$emitTo('contact.delete', 'confirmDelete', {{ $user->id }})">
                        {{ __('Delete Contact') }}
                    </x-jet-danger-button>
                </div>

                
            </x-slot>
        </x-jet-form-section>
        <livewire:contact.delete :contact="$user" :key="$user->id" />
    @endif

    <x-jet-section-border />
</div>
