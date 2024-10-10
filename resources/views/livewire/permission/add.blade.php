<div class="p-4"> 
    <div class="flex items-center justify-end">
        <x-add-button :disabled="!userAccess('PERMISSION', 'create')" wire:click="actionShowModal">
            {{ __('Add Menu') }}
        </x-add-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Permission') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <label for="for" class="block text-gray-700 text-sm font-medium">{{ __('For') }}</label>
                <select id="for" wire:model="for"
                    class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                @error('for')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="model" value="{{ __('Menu') }}" />
                <x-jet-input id="model" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="model"
                    autofocus />
                <x-jet-input-error for="model" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3 flex">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="type.view" name="type.view" wire:model="type.view" wire:model.defer="type.view"
                            type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="type.view" class="font-medium text-gray-700 dark:text-gray-300 ">View</label>
                    </div>
                </div>
                <div class="flex items-start ml-4">
                    <div class="flex items-center h-5">
                        <input id="type.create" name="type.create" wire:model="type.create"
                            wire:model.defer="type.create" type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="type.create" class="font-medium text-gray-700 dark:text-gray-300">Create</label>
                    </div>
                </div>
                <div class="flex items-start ml-4">
                    <div class="flex items-center h-5">
                        <input id="type.update" name="type.update" wire:model="type.update"
                            wire:model.defer="type.update" type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="type.update" class="font-medium text-gray-700 dark:text-gray-300">Update</label>
                    </div>
                </div>
                <div class="flex items-start ml-4">
                    <div class="flex items-center h-5">
                        <input id="type.delete" name="type.delete" wire:model="type.delete"
                            wire:model.defer="type.delete" type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="type.delete" class="font-medium text-gray-700 dark:text-gray-300">Delete</label>
                    </div>
                </div>
                <div class="flex items-start ml-4">
                    <div class="flex items-center h-5">
                        <input id="type.audit" name="type.audit" wire:model="type.audit" wire:model.defer="type.audit"
                            type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="type.audit" class="font-medium text-gray-700 dark:text-gray-300">Audit</label>
                    </div>
                </div>
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
