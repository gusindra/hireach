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
                    <x-jet-button wire:click="actionShowModal">
                        {{ __('Add provider') }}
                    </x-jet-button>
                </div>

                <div class="space-y-6">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                @if ($data->count())
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200 mt-2">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 bg-gray-50 dark:bg-slate-800 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/2">
                                                        provider</th>
                                                    <th
                                                        class="px-6 py-3 bg-gray-50 dark:bg-slate-800 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/4">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-slate-700 divide-y divide-gray-200">
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                            <div class="">
                                                                <div class="flex justify-between">
                                                                    <span>
                                                                        {{ $item->provider->code }}
                                                                    </span>

                                                                    <span>
                                                                        {{ $item->provider->name }}
                                                                    </span>

                                                                    <span>
                                                                        {{ $item->channel }}
                                                                    </span>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
                                                            <div class="flex items-center">
                                                                <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                                    wire:click="deleteShowModal('{{ $item->id }}')">
                                                                    {{ __('Delete') }}
                                                                </button>
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
            {{ __('Action message') }}
        </x-slot>

        <x-slot name="content">

            <div class="col-span-6 sm:col-span-4 p-3 space-y-3">
                <div>
                    <x-jet-label for="input.providerId" value="{{ __('Resource') }}" />
                    <select name="input.providerId" id="input.providerId"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="input.providerId">
                        <option selected value="text">--Select provider--</option>
                        @if ($array_data)
                            @foreach ($array_data as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <x-jet-input-error for="input.providerId" class="mt-2" />
                </div>
                <div>

                    <x-jet-label for="input.channel" value="{{ __('input.Channel') }}" />
                    <select name="input.channel" id="input.channel"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="input.channel">
                        <option selected value="text">--Select input.channel--</option>
                        @if ($input['providerId'] == 1)
                            <option value="SMSOTP">SMS OTP</option>
                            <option value="SMSOTP">WABA</option>
                        @endif
                        @if ($input['providerId'] == 2)
                            <option value="SMSNONOTP">SMS NON OTP</option>
                            <option value="SMSOTP">WABA</option>
                        @endif
                        @if ($input['providerId'] == 3)
                            <option value="EMAIL">EMAIL</option>
                        @endif
                        @if ($input['providerId'] == 4)
                            <option value="SMSLN">SMS LONGNUMBER</option>
                            <option value="WALN">WA LONGNUMBER</option>
                        @endif
                    </select>
                    <x-jet-input-error for="channel" class="mt-2" />
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
