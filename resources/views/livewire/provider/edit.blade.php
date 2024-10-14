<div>
    <x-jet-form-section submit="updateStatus({{ $provider->id }})">
        <x-slot name="title">
            {{ __('Status Provider') }}
        </x-slot>

        <x-slot name="description">
            {{ __('This is for Enable / Disable Provider.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-300">
                    You have {{$status?'':'not'}} enabled <span class="uppercase">{{$provider->name}}</span>.
                </h3>
                <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-slate-300">
                    <p>
                        When this provider is enabled, system will able to sending message via channel set by this provider and {{$status?'active used':'will used'}} by {{count($provider->users)}} of clients.
                    </p>
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="updated">
                {{ __('Provider updated.') }}
            </x-jet-action-message>
            @if(!$status)
            <x-jet-button :disabled="!userAccess('PROVIDER', 'delete')" class="">
                {{ __('Enable') }}
            </x-jet-button>
            @else
            <x-jet-button :disabled="!userAccess('PROVIDER', 'delete')" class="bg-red-600">
                {{ __('Disable') }}
            </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="update({{ $provider->id }})">
        <x-slot name="title">
            {{ __('Provider') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The Provider`s information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 flex flex-col">
                <!-- Provider Code -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="code" value="{{ __('Code') }}" />
                    <x-jet-input id="code" type="text" class="mt-1 block w-full" wire:model="code"
                        wire:model.defer="code" wire:model.debunce.800ms="code" />
                    <x-jet-input-error for="code" class="mt-2" />
                </div>
            </div>


            <div class="col-span-6 flex flex-col">
                <!-- Provider Name -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name"
                        wire:model.defer="name" wire:model.debunce.800ms="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 flex flex-col">
                <!-- Provider Company -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="company" value="{{ __('Company') }}" />
                    <x-jet-input id="company" type="text" class="mt-1 block w-full" wire:model="company"
                        wire:model.defer="company" wire:model.debunce.800ms="company" />
                    <x-jet-input-error for="company" class="mt-2" />
                </div>
            </div>


            <div class="col-span-6 flex flex-col">
                <!-- Provider Channel -->
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="channel" :value="__('Channel')" />
                    <select id="channel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" wire:model="selectedSku">
                        <option value="">{{ __('Select a Channel') }}</option>
                        @foreach($commerceItem as $item)
                            @if(!in_array($item->sku, $selectedChannels))
                                <option value="{{ $item->sku }}">{{ strtoupper($item->sku) }}</option>
                            @endif
                        @endforeach
                    </select>
                    <x-jet-input-error for="channel" class="mt-2" />
                </div>

                <div class="flex w-full flex-nowrap overflow-x-auto gap-3 mt-4">
                    @foreach($selectedChannels as $sku)
                        <!-- Item Tag -->
                        <div class="flex items-center rounded-lg bg-blue-100 px-4 py-2 text-black shadow whitespace-nowrap">
                            <span class="text-sm">{{ $sku }}</span>
                            <button wire:click="removeChannel('{{ $sku }}')" class="ml-2 flex h-6 w-6 items-center justify-center rounded-md bg-red-500 text-white hover:bg-red-600 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>




        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Provider  Updated.') }}
            </x-jet-action-message>

            <x-jet-button :disabled="!userAccess('PROVIDER', 'update')">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />
    @livewire('provider.add-setting-provider', ['provider' => $provider])
    <x-jet-section-border />

    <x-jet-form-section submit="actionShowDeleteModal">
        <x-slot name="title">
            {{ __('Delete Provider') }}
        </x-slot>

        <x-slot name="description">
            {{ __('This is for delete Provider.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 mx-4 text-right">
                </div>
                <div class="col-span-12 sm:col-span-1 mx-4 text-right">
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Provider saved.') }}
            </x-jet-action-message>

            <x-jet-button :disabled="!userAccess('PROVIDER', 'delete')" class="bg-red-600" wire:click="actionShowDeleteModal">
                {{ __('Delete Provider') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-dialog-modal class="text-left" wire:model="modalDeleteVisible">
        <x-slot name="title">
            {{ __('Delete Provider') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('Are you sure you want to delete this provider?') }}</p>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
