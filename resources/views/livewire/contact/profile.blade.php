<div>
    <x-jet-form-section submit="saveUser({{$user->id}})">
        <x-slot name="title">
            {{ __('User Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update user profile information and email address.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Profile Photo -->
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">

                <label class="block font-medium text-sm text-gray-700 dark:text-slate-300" for="photo">
                    Photo
                </label>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="https://ui-avatars.com/api/?name={{$user->name}}&amp;color=7F9CF5&amp;background=EBF4FF" alt="Admin" class="rounded-full h-20 w-20 object-cover">
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <select
                        name="title"
                        id="title"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="inputclient.title"
                        >
                        <option {{$user->title=='Mr.'?'selected':''}} value="Mr.">Mr.</option>
                        <option {{$user->title=='Mrs.'?'selected':''}} value="Mrs.">Mrs.</option>
                        <option {{$user->title=='Miss'?'selected':''}} value="Miss">Miss</option>
                        <option {{$user->title=='Ms.'?'selected':''}} value="Ms.">Ms.</option>
                        <option {{$user->title=='PT.'?'selected':''}} value="PT.">PT.</option>
                        <option {{$user->title=='CV.'?'selected':''}} value="CV.">CV.</option>
                        <option {{$user->title=='none'?'selected':''}} value="none">None</option>
                    </select>
                    <x-jet-input-error for="title" class="mt-2" />
                </div>
            </div>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.name" value="{{ __('Name') }}" />
                    <x-jet-input id="name"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.name"
                        wire:model.defer="inputuser.name"
                        wire:model.debunce.800ms="inputuser.name" />
                    <x-jet-input-error for="inputuser.name" class="mt-2" />
                </div>
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.email" value="{{ __('Email') }}" />
                    <x-jet-input id="email"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.email"
                        wire:model.defer="inputuser.email"
                        wire:model.debunce.800ms="inputuser.email" />
                    <x-jet-input-error for="inputuser.email" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.phone" value="{{ __('Phone') }}" />
                    <x-jet-input id="phone"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.phone"
                        wire:model.defer="inputuser.phone"
                        wire:model.debunce.800ms="inputuser.phone" />
                    <x-jet-input-error for="inputuser.phone" class="mt-2" />
                </div>
            </div>
            
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="user_saved">
                {{ __('Profile user saved.') }}
            </x-jet-action-message>

            <x-save-button show="{{$user->status=='draft'?'true':'false'}}">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="saveClient">
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
                    <x-jet-label for="inputuser.nick" value="{{ __('Sender') }}" />
                    <x-jet-input id="nick"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.nick"
                        wire:model.defer="inputuser.nick"
                        wire:model.debunce.800ms="inputuser.nick" />
                    <x-jet-input-error for="inputuser.nick" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.nick" value="{{ __('Identity') }}" />
                    <x-jet-input id="nick"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.nick"
                        wire:model.defer="inputuser.nick"
                        wire:model.debunce.800ms="inputuser.nick" />
                    <x-jet-input-error for="inputuser.nick" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.nick" value="{{ __('Note') }}" />
                    <x-jet-input id="nick"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.nick"
                        wire:model.defer="inputuser.nick"
                        wire:model.debunce.800ms="inputuser.nick" />
                    <x-jet-input-error for="inputuser.nick" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.nick" value="{{ __('Tag') }}" />
                    <x-jet-input id="nick"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.nick"
                        wire:model.defer="inputuser.nick"
                        wire:model.debunce.800ms="inputuser.nick" />
                    <x-jet-input-error for="inputuser.nick" class="mt-2" />
                </div>
            </div>
            <!-- Nick -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputuser.nick" value="{{ __('Source') }}" />
                    <x-jet-input id="nick"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputuser.nick"
                        wire:model.defer="inputuser.nick"
                        wire:model.debunce.800ms="inputuser.nick" />
                    <x-jet-input-error for="inputuser.nick" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="inputclient.address" value="{{ __('Address') }}" />
                    <x-jet-input id="address"
                        type="text"
                        class="mt-1 block w-full"
                        wire:model="inputclient.address"
                        wire:model.defer="inputclient.address"
                        wire:model.debunce.800ms="inputclient.address" />
                    <x-jet-input-error for="inputclient.address" class="mt-2" />
                </div>
            </div>
            <div class="col-span-12 sm:col-span-3">
                <x-jet-label for="inputclient.notes" value="{{ __('Notes') }}" />
                <x-jet-input id="notes"
                    type="text"
                    class="mt-1 block w-full"
                    wire:model="inputclient.notes"
                    wire:model.defer="inputclient.notes"
                    wire:model.debunce.800ms="inputclient.notes" />
                <x-jet-input-error for="inputclient.notes" class="mt-2" />
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="client_saved">
                {{ __('Client data saved.') }}
            </x-jet-action-message>

            <x-save-button show="{{$user->status=='draft'?'true':'false'}}">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

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
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                    Before deleting your account, please download any data or information that you wish to
                    retain.
                </div>

                <!-- Delete User Confirmation Modal -->
                <div class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: none;">
                    <div  class="fixed inset-0 transform transition-all"  x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div  class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" style="display: none;">
                        <div class="px-6 py-4">
                            <div class="text-lg">
                                Delete Account
                            </div>

                            <div class="mt-4">
                                Are you sure you want to delete your account? Once your account is deleted, all
                                of its resources and data will be permanently deleted. Please enter your
                                password to confirm you would like to permanently delete your account.

                                <div class="mt-4">
                                    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4" type="password" placeholder="Password" x-ref="password" wire:model.defer="password" wire:keydown.enter="deleteUser">

                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-100 text-right">
                            <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                                Cancel
                            </button>

                            <button type="button" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 disabled:opacity-25 transition ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="client_saved">
                {{ __('Client data saved.') }}
            </x-jet-action-message>
            <button 
                type="button" 
                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 disabled:opacity-25 transition" 
                wire:click="$emit('triggerDelete',{{ $user->id }})"
                {{-- onclick="confirm('Are you sure you want to delete this contact?') || event.stopImmediatePropagation()" --}}
            >
                Delete Account
            </button>
            {{-- <x-save-button show="{{$user->status=='draft'?'true':'false'}}">
                {{ __('Save') }}
            </x-jet-button> --}}
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />
    @push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {

            @this.on('triggerDelete', id => {
                Swal.fire({
                    title: 'Are You Sure?',
                    html: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.value) {
                        @this.call('delete',id)
                    }
                });
            });
        })
    </script>
    @endpush
</div>
