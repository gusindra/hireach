<div>
    <x-jet-button wire:click="showModal">
        Export Data
    </x-jet-button>

    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Export Data Contact
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label for="type_input" value="Type Input" />
                <select id="type_input" wire:model="type_input" class="block w-full mt-1 border-gray-300 rounded">
                    <option value="">Pilih Type Input</option>
                    <option value="skip_trace">Skip Trace</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="celluler_no">Celluler No</option>
                    <option value="geolocation_tagging">Geolocation Tagging</option>
                    <option value="recycle_status">Mobile No. Recycle</option>
                </select>
                @error('type_input') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <x-jet-label for="file_name" value="File Name" />
                <select id="file_name" wire:model="file_name" class="block w-full mt-1 border-gray-300 rounded">
                    <option value="">Pilih File Name</option>
                    @foreach($files as $file)
                        <option value="{{ $file }}">{{ $file }}</option>
                    @endforeach
                </select>
                @error('file_name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="hideModal">
                Cancel
            </x-jet-secondary-button>

            <x-jet-button wire:click="export" class="ml-2">
                Export
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @if (Session::has('success'))
        <div class="bg-green-500 text-white p-4 mt-4 rounded">
            {{ Session::get('success') }}
        </div>
    @endif
</div>
