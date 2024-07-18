<div>
    <!-- Manage List Action -->

    <x-jet-action-section>
        <x-slot name="title">
            {{ __('Add Provider Setting') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Add a new setting for the provider to your profile.') }}
        </x-slot>

        <!-- Action List -->
        <x-slot name="content">
            <div class="flex items-center justify-end text-right">
                <x-jet-action-message class="mr-3" on="added">
                    {{ __('Action added.') }}
                </x-jet-action-message>
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Action saved.') }}
                </x-jet-action-message>
                <x-jet-action-message class="mr-3 text-red-500" on="exist">
                    {{ __('Setting already exists.') }}
                </x-jet-action-message>
                <x-add-button wire:click="actionShowModal">
                    {{ __('Add Setting') }}
                </x-add-button>
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
                                                    Key
                                                </th>
                                                <th
                                                    class="px-6 py-3 bg-gray-50 dark:bg-slate-800 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/2">
                                                    Value
                                                </th>
                                                <th
                                                    class="px-6 py-3 bg-gray-50 dark:bg-slate-800 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider w-1/4">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-slate-700 divide-y divide-gray-200">
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                        {{ $item->key }}
                                                    </td>
                                                    <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                                        {{ $item->value }}
                                                    </td>
                                                    <td
                                                        class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
                                                        <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                            wire:click="deleteShowModal('{{ $item->id }}')">
                                                            {{ __('Delete') }}
                                                        </button>
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


    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Add Provider Setting') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3 space-y-3">
                <div>
                    <x-jet-label for="key" value="{{ __('Key') }}" />
                    <x-jet-input id="key" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="key" />
                    <x-jet-input-error for="key" class="mt-2" />
                </div>
                <div>
                    <x-jet-label for="value" value="{{ __('Value') }}" />
                    <x-jet-input id="value" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="value" />
                    <x-jet-input-error for="value" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Add') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Remove Action Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingActionRemoval">
        <x-slot name="title">
            {{ __('Remove Confirmation') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this setting?') }}
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
