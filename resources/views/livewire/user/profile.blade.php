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

            <!-- Name -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="inputuser.name"
                        wire:model.defer="inputuser.name" wire:model.debunce.800ms="inputuser.name" />
                    <x-jet-input-error for="inputuser.name" class="mt-2" />
                </div>
            </div>

            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.nick" value="{{ __('Nick') }}" />
                    <x-jet-input id="nick" type="text" class="mt-1 block w-full" wire:model="inputuser.nick"
                        wire:model.defer="inputuser.nick" wire:model.debunce.800ms="inputuser.nick" />
                    <x-jet-input-error for="inputuser.nick" class="mt-2" />
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

            <x-save-button :disabled="!userAccess('USER', 'update')" show="{{ $user->status == 'draft' ? 'true' : 'false' }}">
                {{ __('Save') }}
                </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="saveClient">
        <x-slot name="title">
            {{ __('Update Client Billing') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update user billing information and billing address.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="type" value="{{ __('Type') }}" />
                    <select name="type" id="type"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="inputclient.type">
                        <option selected>-- Select --</option>
                        <option value="prepaid">PrePaid</option>
                        <option value="postpaid">PostPaid</option>
                    </select>
                    <x-jet-input-error for="type" class="mt-2" />
                </div>
            </div>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <select name="title" id="title"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="inputclient.title">
                        <option selected>-- Select --</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Miss">Miss</option>
                        <option value="Ms.">Ms.</option>
                        <option value="PT.">PT.</option>
                        <option value="CV.">CV.</option>
                        <option value="none">None</option>
                    </select>
                    <x-jet-input-error for="title" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.name" value="{{ __('Name') }}" />
                    <x-jet-input id="client_name" type="text" class="mt-1 block w-full" wire:model="inputclient.name"
                        wire:model.defer="inputclient.name" wire:model.debunce.800ms="inputclient.name" />
                    <x-jet-input-error for="inputclient.name" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.phone" value="{{ __('Phone') }}" />
                    <x-jet-input id="client_phone" type="text" class="mt-1 block w-full"
                        wire:model="inputclient.phone" wire:model.defer="inputclient.phone"
                        wire:model.debunce.800ms="inputclient.phone" />
                    <x-jet-input-error for="inputclient.phone" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.tax_id" value="{{ __('Tax ID / NPWP') }}" />
                    <x-jet-input id="inputclient.tax_id" type="text" class="mt-1 block w-full"
                        wire:model="inputclient.tax_id" wire:model.defer="inputclient.tax_id"
                        wire:model.debunce.800ms="inputclient.tax_id" />
                    <x-jet-input-error for="inputclient.tax_id" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.postcode" value="{{ __('Post Code') }}" />
                    <x-jet-input id="postcode" type="text" class="mt-1 block w-full"
                        wire:model="inputclient.postcode" wire:model.defer="inputclient.postcode"
                        wire:model.debunce.800ms="inputclient.postcode" />
                    <x-jet-input-error for="inputclient.postcode" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.address" value="{{ __('Address') }}" />
                    <x-jet-input id="address" type="text" class="mt-1 block w-full"
                        wire:model="inputclient.address" wire:model.defer="inputclient.address"
                        wire:model.debunce.800ms="inputclient.address" />
                    <x-jet-input-error for="inputclient.address" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.province" value="{{ __('Province') }}" />
                    <x-jet-input id="province" type="text" class="mt-1 block w-full"
                        wire:model="inputclient.province" wire:model.defer="inputclient.province"
                        wire:model.debunce.800ms="inputclient.province" />
                    <x-jet-input-error for="inputclient.province" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.city" value="{{ __('City') }}" />
                    <x-jet-input id="city" type="text" class="mt-1 block w-full"
                        wire:model="inputclient.city" wire:model.defer="inputclient.city"
                        wire:model.debunce.800ms="inputclient.city" />
                    <x-jet-input-error for="inputclient.city" class="mt-2" />
                </div>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <x-jet-label for="inputclient.notes" value="{{ __('Notes') }}" />
                <x-jet-input id="notes" type="text" class="mt-1 block w-full" wire:model="inputclient.notes"
                    wire:model.defer="inputclient.notes" wire:model.debunce.800ms="inputclient.notes" />
                <x-jet-input-error for="inputclient.notes" class="mt-2" />
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="client_saved">
                {{ __('Client data saved.') }}
            </x-jet-action-message>

            <x-save-button :disabled="!userAccess('USER', 'update')" show="{{ $user->status == 'draft' ? 'true' : 'false' }}">
                {{ __('Save') }}
                </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

</div>
