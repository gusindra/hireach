<div>
    <x-jet-button wire:click="$set('showModal', true)">
        {{ __('Edit') }}
    </x-jet-button>
    <!-- Edit Setting Modal -->
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Edit Setting
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-jet-label for="value" value="Value" class="text-left" />
                    <x-jet-input id="value" type="text" class="mt-1 block w-full" wire:model.defer="value" />
                    @error('value')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <x-jet-label for="remark" value="Remark" class="text-left" />
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
            <x-jet-button class="ml-2" wire:click="update">
                Save
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
