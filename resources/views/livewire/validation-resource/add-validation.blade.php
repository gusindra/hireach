<div>
    <!-- Button to open modal -->
    <x-jet-button wire:click="openModal">Add By Phone</x-jet-button>

    <!-- Jetstream Modal -->
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Upload Validation File
        </x-slot>

        <x-slot name="content">
            <div>
                <div class="mt-4">
                    <x-jet-label for="file" value="Select File" />
                    <input type="file" id="file" wire:model="file"
                        class="mt-2 border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    <x-jet-input-error for="file" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="type" value="Type" />
                    <select id="type" wire:model="type"
                        class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        <option value="" disabled>Select a type</option>
                        <option value="cellular_no">Cellular Number</option>
                        <option value="whatsapps">WhatsApp</option>
                    </select>
                    <x-jet-input-error for="type" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" type="submit" wire:click="uploadFile" wire:loading.attr="disabled">
                Upload
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
