<div>
    <!-- Manage List Action -->
    <div class="mt-10 sm:mt-0">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Add Contact') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add new contact to list Audience.') }}
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
                        {{ __('Contact Already Exist.') }}
                    </x-jet-action-message>
                    <livewire:audience.import-contact :audience="$audience" />



                    <x-link-button wire:click="exportContact">
                        {{ __('Export Contact') }}
                    </x-link-button>
                    <x-add-button wire:click="actionShowModal">
                        {{ __('Add New Contact') }}
                    </x-add-button>
                </div>

                <div class="space-y-6">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                @if ($data->count())
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        @livewire('table.audience-contact-table')
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
            {{ __('Action add contact') }}
        </x-slot>

        <x-slot name="content">

            <div class="col-span-6 sm:col-span-4 p-3">

                {{-- <select name="contactId" id="contactId"
                    class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="contactId">
                    <option selected value="text">--Select Contact--</option>
                    @if ($array_data)
                        @foreach ($array_data as $contact)
                            <option value="{{ $contact->uuid }}">{{ $contact->name }}</option>
                        @endforeach
                    @endif
                </select> --}}
                <livewire:table.list-contact-add :audience="$audience" :hide-pagination="true" />

                {{-- @livewire('table.list-contact-add', ['audience' => $audience->id]) --}}
                <x-jet-input-error for="contactId" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>

    <!-- Remove Action Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingActionRemoval">
        <x-slot name="title">
            {{ __('Remove Confirmation') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this message?') }}<br>

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
