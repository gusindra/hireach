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
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="inputuser.name"
                        wire:model.defer="inputuser.name" wire:model.debunce.800ms="inputuser.name" />
                    <x-jet-input-error for="inputuser.name" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.description" value="{{ __('Description') }}" />
                    <x-jet-input id="description" type="text" class="mt-1 block w-full"
                        wire:model="inputuser.description" wire:model.defer="inputuser.description"
                        wire:model.debunce.800ms="inputuser.description" />
                    <x-jet-input-error for="inputuser.description" class="mt-2" />
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
            <div class="col-span-12">
                <div class="text-sm text-gray-600 dark:text-slate-300">
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                    Before deleting your account, please download any data or information that you wish to
                    retain.
                </div>

                <!-- Delete Audience Confirmation Modal -->
                <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
                    style="display: none;">
                    <div class="fixed inset-0 transform transition-all" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" style="display: none;">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        style="display: none;">
                        <div class="px-6 py-4">
                            <div class="text-lg">
                                Delete Audience
                            </div>

                            <div class="mt-4">
                                Are you sure you want to delete this Audience? Once data is deleted, all
                                of its resources and data will be permanently deleted. Please enter your
                                password to confirm you would like to permanently delete your account.

                                <div class="mt-4">
                                    <input
                                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                                        type="password" placeholder="Password" x-ref="password"
                                        wire:model.defer="password" wire:keydown.enter="deleteUser">

                                </div>
                            </div>
                        </div>

                        {{-- Delete Audience --}}
                        <div class="px-6 py-4 bg-gray-100 text-right">
                            <div>
                                <x-jet-danger-button
                                    wire:click="$emitTo('audience.delete', 'confirmDelete', {{ $user->id }})">
                                    {{ __('Delete Audience') }}
                                </x-jet-danger-button>
                            </div>

                            <livewire:audience.delete :audience="$user" :key="$user->id" />

                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="client_saved">
                {{ __('Client data saved.') }}
            </x-jet-action-message>
            {{-- <button type="button"
                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 disabled:opacity-25 transition"
                wire:click="$emit('triggerDelete',{{ $user->id }})" onclick="confirm('Are you sure you want to delete this contact?') || event.stopImmediatePropagation()">
                Delete Account
            </button> --}}


            @if ($user)
                <div>
                    <x-jet-danger-button wire:click="$emitTo('audience.delete', 'confirmDelete', {{ $user->id }})">
                        {{ __('Delete Audience') }}
                    </x-jet-danger-button>
                </div>

                <livewire:audience.delete :audience="$user" :key="$user->id" />
            @endif

            {{-- <x-save-button show="{{$user->status=='draft'?'true':'false'}}">
                {{ __('Save') }}
            </x-jet-button> --}}
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

</div>
