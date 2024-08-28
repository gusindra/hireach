<div class="p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
    @if (session()->has('message'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <div>
            <x-jet-label for="no_ktp" value="KTP Number" />
            <x-jet-input id="no_ktp" type="text" class="block w-full mt-1" wire:model="no_ktp" />
            @error('no_ktp')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-jet-label for="status_wa" value="WhatsApp Status" />
            <x-jet-input id="status_wa" type="text" class="block w-full mt-1" wire:model="status_wa" />
            @error('status_wa')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-jet-label for="status_no" value="Number Status" />
            <x-jet-input id="status_no" type="text" class="block w-full mt-1" wire:model="status_no" />
            @error('status_no')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-jet-label for="type" value="Type" />
            <x-jet-input id="type" type="text" class="block w-full mt-1" wire:model="type" />
            @error('type')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-jet-label for="phone_number" value="Phone Number" />
            <x-jet-input id="phone_number" type="text" class="block w-full mt-1" wire:model="phone_number" />
            @error('phone_number')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-jet-label for="file_name" value="File Name" />
            <x-jet-input id="file_name" type="text" class="block w-full mt-1" wire:model="file_name" />
            @error('file_name')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <x-jet-label for="activation_date" value="Activation Date" />
            <x-jet-input id="activation_date" type="date" class="block w-full mt-1" wire:model="activation_date" />
            @error('activation_date')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <x-jet-button class="ml-4">
                Save
            </x-jet-button>
        </div>
    </form>
</div>
