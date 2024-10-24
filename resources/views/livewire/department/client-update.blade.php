<div>
    <div class="flex items-center justify-end px-8 text-right">
        <x-add-button wire:click="actionShowModal(true)">
            {{ $selectContact ? __('Update Client') : __('Add Client') }}
        </x-add-button>

        <x-add-button wire:click="actionShowModal(false)" class="ml-4">
            {{ $selectAccount ? __('Update Account') : __('Select Account') }}
        </x-add-button>
    </div>


    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ $isClient ? __('Add Client') : __('Select Account') }}
        </x-slot>

        <x-slot name="content">
            @if ($isClient)
                <!-- Client Form -->
                <div class="col-span-6 sm:col-span-4 p-2">
                    <x-jet-label for="contact" value="{{ __('Client') }}" />
                    <x-jet-input autocomplete="off" id="contact" type="text" class="mt-1 block w-full"
                        placeholder="Existing Client Keyword" list="client" wire:model.debounce.800ms="contact" autofocus />

                    <table class="my-2">
                        @if(count($data)>0)
                            @foreach($data as $da)
                            <tr>
                                <td class="flex gap-2">
                                    <input wire:model.debounce.800ms="selectContact" id="contact-{{$da->id}}" type="radio" name="contact" value="{{$da->id}}" />
                                    <label for="contact-{{$da->id}}">
                                        <b>{{$da->name}}</b> ({{$da->phone}} - {{$da->email}})
                                    </label>
                                </td>
                                <td><img class="h-8" src="{{$da->profile_photo_url}}" /></td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="flex gap-2">
                                    <input wire:model.debounce.800ms="new" id="contact-new" type="checkbox" name="contact" value="0" />
                                    <label for="contact-new">New Client</label>
                                </td>
                                <td></td>
                            </tr>
                        @endif
                    </table>

                    @if ($new)
                    <div class="flex gap-4">
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="input.name" value="{{ __('Name') }}" />
                            <x-jet-input id="client_name" type="text" class="mt-1 block w-full" wire:model="input.name"
                                wire:model.defer="input.name" />
                            <x-jet-input-error for="input.name" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="input.email" value="{{ __('Email') }}" />
                            <x-jet-input id="input.email" type="text" class="mt-1 block w-full"
                                wire:model.debounce.800ms="input.email" />
                            <x-jet-input-error for="input.email" class="mt-2" />
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="input.phone" value="{{ __('Phone') }}" />
                            <x-jet-input id="input.phone" type="text" class="mt-1 block w-full"
                                wire:model.debounce.800ms="input.phone" />
                            <x-jet-input-error for="input.phone" class="mt-2" />
                        </div>
                    </div>
                    @endif
                </div>
            @else
                <!-- Account Selection Form -->
                <div class="col-span-6 sm:col-span-4 p-2">
                    <x-jet-label for="search" value="{{ __('Account') }}" />
                    <x-jet-input autocomplete="off" id="search" type="text" class="mt-1 block w-full"
                        placeholder="Search Account by Name or Email" list="account" wire:model.debounce.800ms="search" autofocus />

                    <table class="my-2">
                        @foreach($users as $user)
                        <tr>
                            <td class="flex gap-8">
                                <input wire:model="selectAccount" id="account-{{$user->id}}" type="radio" name="account" value="{{$user->id}}" />
                                <label for="account-{{$user->id}}">
                                    <b>{{$user->name}}</b> ({{$user->email}})
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="update()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
