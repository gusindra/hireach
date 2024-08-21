<div>
    <!-- Button to open modal -->
    <x-jet-button wire:click="openModal">Add KTP</x-jet-button>

    <!-- Jetstream Modal -->
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Upload KTP File
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
                <div class="mt-4">
                    <x-jet-label for="file" value="Select File" />
                    <input type="file" id="file" wire:model="file"
                        class="mt-2 border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    <x-jet-input-error for="file" class="mt-2" />
                </div>
            </form>
        </x-slot>

        <!-- Footer for modal actions -->
        <x-slot name="footer">
            <div class="mt-4 flex justify-end">
                <x-jet-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="uploadFile" wire:loading.attr="disabled">
                    Upload
                </x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>
