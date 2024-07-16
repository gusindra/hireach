<div class="mx-auto  py-8">
    <div
        class="flex flex-col md:flex-row items-center justify-between p-6 space-y-4 md:space-y-0 bg-white shadow rounded-lg">
        <div class="text-center md:text-left">
            <h2 class="text-2xl font-semibold text-gray-800">Add Settings</h2>
        </div>
        <div class="flex items-center justify-center md:justify-end">
            <x-jet-button wire:click="$set('showModal', true)">
                {{ __('Add Setting') }}
            </x-jet-button>
        </div>
    </div>

    <!-- Add Setting Modal -->
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Add New Setting
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="key" value="Key" />
                    <x-jet-input id="key" type="text" class="mt-1 block w-full" wire:model.defer="key" />
                    @error('key')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-jet-label for="value" value="Value" />
                    <x-jet-input id="value" type="text" class="mt-1 block w-full" wire:model.defer="value" />
                    @error('value')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-jet-label for="remark" value="Remark" />
                    <x-jet-input id="remark" type="text" class="mt-1 block w-full" wire:model.defer="remark" />
                    @error('remark')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showModal', false)">
                Cancel
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="save">
                Save
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Settings List -->
    @if (count($settings) > 0)
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800">Settings</h2>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/4 py-2 px-4 text-left">Key</th>
                            <th class="w-1/2 py-2 px-4 text-left">Value</th>
                            <th class="w-1/4 py-2 px-4 text-left">Remark</th>
                            <th class="w-1/6 py-2 px-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach ($settings as $setting)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-2 px-4">{{ $setting->key }}</td>
                                <td class="py-2 px-4">{{ $setting->value }}</td>
                                <td class="py-2 px-4">{{ $setting->remark ? $setting->remark : '-' }}</td>
                                <td class="py-2 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        @livewire('setting.edit', ['settingId' => $setting->id])
                                        <button
                                            class="bg-red-500 text-white font-bold py-1 px-3 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400"
                                            wire:click="confirmDelete({{ $setting->id }})">
                                            Delete
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">
            Delete Setting
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this setting? This action cannot be undone.
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showDeleteModal', false)">
                Cancel
            </x-jet-secondary-button>
            <x-jet-danger-button class="ml-2" wire:click="delete">
                Delete
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
