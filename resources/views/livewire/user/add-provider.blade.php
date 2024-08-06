<div>
    <!-- Manage List Action -->
    <div class="my-4 mx-3">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Add provider') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add new provider in your profile.') }}
            </x-slot>

            <!-- Team Action List -->
            <x-slot name="content">
                <div class="flex items-center justify-end text-right">
                    <x-jet-action-message class="mr-3" on="added">
                        {{ __('Action added.') }}
                    </x-jet-action-message>
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Action saved.') }}
                    </x-jet-action-message>
                    <x-jet-action-message class="mr-3 text-red-500" on="exist">
                        {{ __('provider Already Exist.') }}
                    </x-jet-action-message>
                    <x-add-button :disabled="!userAccess('USER', 'update')" wire:click="actionShowModal">
                        {{ __('Add provider') }}
                    </x-add-button>
                </div>

                <div class="space-y-6">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                @if ($data->count())
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200 mt-2">

                                            <tbody class="bg-white dark:bg-slate-700 divide-y divide-gray-200">
                                                <tr>
                                                    <td class="w-full px-6 py-4 text-sm whitespace-no-wrap">
                                                        <div class="">
                                                            <div class="grid grid-cols-4 gap-4">
                                                                <b>Provider Code</b>
                                                                <b>Name</b>
                                                                <b>Channel</b>
                                                                <b>From / Sender ID</b>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
                                                    </td>
                                                </tr>
                                                @foreach ($data as $item)
                                                    @if($item)
                                                        <tr>
                                                            <td class="w-full px-6 py-4 text-sm whitespace-no-wrap">
                                                                <div class="">
                                                                    <div class="grid grid-cols-4 gap-4">
                                                                        <span>
                                                                            {{ $item->provider ? $item->provider->code : '-' }}
                                                                        </span>

                                                                        <span>
                                                                            {{ $item->provider ? $item->provider->name : '-' }}
                                                                        </span>

                                                                        <span>
                                                                            {{ $item->channel }}
                                                                        </span>

                                                                        <span>
                                                                            {{ $item->from }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                             class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
                                                            <div class="flex items-center">
                                                                <x-link-button :disabled="!userAccess('USER', 'delete')"
                                                                    class="cursor-pointer ml-6 text-sm"
                                                                    wire:click="deleteShowModal('{{ $item->id }}')">
                                                                    {{ __('Delete') }}
                                                                </x-link-button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </x-slot>
        </x-jet-action-section>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Action Add Provider') }}
        </x-slot>

        <x-slot name="content">

            <div class="col-span-6 sm:col-span-4 p-3 space-y-3">
                <div>
                    <x-jet-label for="provider_id" value="{{ __('Resource') }}" />
                    <select name="provider_id" id="provider_id"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="input.provider_id">
                        <option selected value="text">--Select provider--</option>
                        @if ($array_data)
                            @foreach ($array_data as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-jet-input-error for="provider_id" class="mt-2" />
                </div>

                <div>
                    <x-jet-label for="channel" value="{{ __('Channel') }}" />
                    <select name="channel" id="channel"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debounce.800ms="input.channel">
                        <option selected value="">--Select channel--</option>
                        @foreach ($channels as $channel)
                            <option value="{{ $channel }}">{{ $channel }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="channel" class="mt-2" />
                </div>

                <div>
                    <x-jet-label for="from" value="{{ __('From/Sender ID') }}" />
                    <x-jet-input id="from" type="text" class="mt-1 block w-full"
                        wire:model.debunce.800ms="input.from" autofocus />
                    <x-jet-input-error for="from" class="mt-2" />
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            @if ($actionId)
                <x-jet-button class="ml-2" wire:click="addProvider" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>
            @else
                <x-jet-button class="ml-2" wire:click="addProvider" wire:loading.attr="disabled">
                    {{ __('Add') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Remove Action Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingActionRemoval">
        <x-slot name="title">
            {{ __('Remove Confirmation') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this provider?') }}<br>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingActionRemoval')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
