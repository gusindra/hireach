<div>
    <div class="flex items-center text-right">
        <x-link-button wire:click="actionShowModal">
            {{ __('Import Contact') }}
        </x-link-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Contact') }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="import">
                <div class="col-span-6 sm:col-span-3 grid grid-cols-3 gap-2 space-y-2 p-2">
                    <input type="file" wire:model="file" accept=".csv,.xlsx,.xls">
                    @error('file')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button type="submit" wire:click="import" x-on:click="$refs.myForm.submit()">
                {{ __('Import') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    @if (session()->has('success'))
        <div class="mt-4 alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
