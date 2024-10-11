<div>
    @if (userAccess('USER', 'create'))
        <div class="flex flex-row-reverse">
            <x-add-button :show="userAccess('USER', 'create')" :disabled="!userAccess('USER', 'create')" wire:click="actionShowModal">
                {{$role == 'admin' ? 'Add Admin' : 'Add User'}}
            </x-add-button>
        </div>
    @endif


    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New User') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="input.name" value="{{ __('Name') }}" />
                <x-jet-input id="input.name" type="text" class="mt-1 block w-full"
                    wire:model.debunce.800ms="input.name" autofocus />
                <x-jet-input-error for="input.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="input.email" value="{{ __('Email') }}" />
                <x-jet-input autocomplete="off" id="input.email" type="text" class="mt-1 block w-full"
                    wire:model.debunce.800ms="input.email" autofocus />
                <x-jet-input-error for="input.email" class="mt-2" />
            </div>

            @if ($role==="admin")

            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="role" value="{{ __('Role') }}" />

                <!-- Dropdown untuk memilih role -->
                <select id="roleId" wire:model="roleId" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">{{ __('Select Role') }}</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <x-jet-input-error for="role" class="mt-2" />
            </div>
            @endif


            <div class="col-span-6 sm:col-span-4 p-3 grid grid-cols-3 gap-3">
                <div class="col-span-2">
                    <x-jet-label for="input.password" value="{{ __('Password') }}" />
                    <!-- <x-jet-input id="input.password" type="password" class="mt-1 block w-full" wire:model.debunce.800ms="input.password" autofocus /> -->
                    <div class="relative" x-data="{ input: 'password' }">
                        <input autocomplete="off" id="input.password"
                            class="p-2 border dark:bg-slate-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            wire:model.debunce.800ms="input.password" autofocus name="input.password" type="password"
                            x-bind:type="input">
                        <div class="absolute right-0 top-0 mr-2 mt-2"
                            x-on:click="input = (input === 'password') ? 'text' : 'password'">
                            <span class="body text-xs text-show-hide text-gray-600 uppercase cursor-pointer"
                                x-text="input == 'password' ? 'show' : 'hide'">show</span>
                        </div>
                    </div>
                    <x-jet-input-error for="input.password" class="mt-2" />
                </div>
                <div class="col-span-1">
                    <x-jet-secondary-button class="mt-6 py-3" wire:click="generatePassword"
                        wire:loading.attr="disabled">
                        {{ __('Auto Password') }}
                    </x-jet-secondary-button>
                </div>
            </div>
            <div class="{{ $showClients ? 'block' : 'hidden' }}">
                <hr class="my-4">
                <x-jet-label for="addressed_company" value="{{ __('Client Information') }}" />
                <!-- Name -->
                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
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
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="inputclient.name" value="{{ __('Name') }}" />
                        <x-jet-input id="client_name" type="text" class="mt-1 block w-full"
                            wire:model="inputclient.name" wire:model.defer="inputclient.name"
                            wire:model.debunce.800ms="inputclient.name" />
                        <x-jet-input-error for="inputclient.name" class="mt-2" />
                    </div>
                </div>
                <!-- Nick -->
                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="inputclient.phone" value="{{ __('Phone') }}" />
                        <x-jet-input id="client_phone" type="text" class="mt-1 block w-full"
                            wire:model="inputclient.phone" wire:model.defer="inputclient.phone"
                            wire:model.debunce.800ms="inputclient.phone" />
                        <x-jet-input-error for="inputclient.phone" class="mt-2" />
                    </div>
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="inputclient.tax_id" value="{{ __('Tax ID / NPWP') }}" />
                        <x-jet-input id="inputclient.tax_id" type="text" class="mt-1 block w-full"
                            wire:model="inputclient.tax_id" wire:model.defer="inputclient.tax_id"
                            wire:model.debunce.800ms="inputclient.tax_id" />
                        <x-jet-input-error for="inputclient.tax_id" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="inputclient.postcode" value="{{ __('Post Code') }}" />
                        <x-jet-input id="postcode" type="text" class="mt-1 block w-full"
                            wire:model="inputclient.postcode" wire:model.defer="inputclient.postcode"
                            wire:model.debunce.800ms="inputclient.postcode" />
                        <x-jet-input-error for="inputclient.postcode" class="mt-2" />
                    </div>
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="inputclient.address" value="{{ __('Address') }}" />
                        <x-jet-input id="address" type="text" class="mt-1 block w-full"
                            wire:model="inputclient.address" wire:model.defer="inputclient.address"
                            wire:model.debunce.800ms="inputclient.address" />
                        <x-jet-input-error for="inputclient.address" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3 grid grid-cols-2 gap-2">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="inputclient.province" value="{{ __('Province') }}" />
                        <x-jet-input id="province" type="text" class="mt-1 block w-full"
                            wire:model="inputclient.province" wire:model.defer="inputclient.province"
                            wire:model.debunce.800ms="inputclient.province" />
                        <x-jet-input-error for="inputclient.province" class="mt-2" />
                    </div>
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
                    <x-jet-input id="notes" type="text" class="mt-1 block w-full"
                        wire:model="inputclient.notes" wire:model.defer="inputclient.notes"
                        wire:model.debunce.800ms="inputclient.notes" />
                    <x-jet-input-error for="inputclient.notes" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>



            @if ($role)
                <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Create Admin') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-2" wire:click="createUser" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</div>
