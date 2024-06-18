<div>
    <div class="flex items-center">
        <x-jet-button wire:click="actionShowModalOneWay">
            {{ __('Add Campaign') }}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Campaign') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model.defer="title" autofocus />
                <x-jet-input-error for="title" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="way_type" value="{{ __('Way Type') }}" />
                <select id="way_type" wire:model.defer="way_type"
                    class="form-multiselect block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option selected value="">Select Type Way</option>
                    <option value="1">One Way</option>
                    <option value="2">Two Way</option>
                </select>
                <x-jet-input-error for="way_type" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
