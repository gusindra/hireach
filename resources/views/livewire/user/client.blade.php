<div>
    <x-jet-form-section submit="addToUser">
        <x-slot name="title">
            {{ __('Convert Client To User') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The basic information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="flex col-span-6 gap-4">

                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model="email" />
                        <x-jet-input-error for="email" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="phone" value="{{ __('Phone') }}" />
                        <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model="phone" />
                        <x-jet-input-error for="phone" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <div class="flex">
                            <x-jet-input id="password" type="text" class="mt-1 block w-full" wire:model="password" />
                            <x-link-button type="button" class="ml-2 text-xs p-0" wire:click="generatePassword">
                                {{ __('Generate Password') }}
                            </x-link-button>
                        </div>
                        <x-jet-input-error for="password" class="mt-2" />
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-button>
                {{ __('Add to User') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="update">
        <x-slot name="title">
            {{ __('Update Contact Client') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The basic information.') }}
        </x-slot>

        <x-slot name="form">
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

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model="email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="phone" value="{{ __('Phone') }}" />
                    <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model="phone" />
                    <x-jet-input-error for="phone" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    @if ($client->theUser->department)
        <x-jet-section-border />

        <livewire:contact.department :client="$client" :isadmin="true" />
        <x-jet-section-border />
    @endif

    <x-jet-section-border />
    @if (session()->has('message'))
        <div class="mt-4 alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>
