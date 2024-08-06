<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{ __('Send Message') }}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Message') }}
        </x-slot>

        <x-slot name="content">
            @livewire('resource.add-resource', ['uuid' => request()->get('resource'), 'modal' => true])
            <x-jet-action-message class="mr-3" on="resource_saved">
                {{ __('Resource data saved.') }}
            </x-jet-action-message>
        </x-slot>

        <x-slot name="footer">
        <a class="inline-flex items-center border border-transparent rounded-md h-8 p-4 mt-4 text-xs text-blue-800 disabled:opacity-25 transition"
            href="{{ route('show.resource') }}?resource={{$way}}">Go to Form Resource {{$way}}Way</a>
        <button class="inline-flex items-center border border-transparent rounded-md h-8 p-4 mt-4 text-xs text-blue-800 disabled:opacity-25 transition cursor-pointer"
            href="#" wire:click="$toggle('modalActionVisible')">Cancel</button>
            <!-- <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button> -->
        </x-slot>
    </x-jet-dialog-modal>
</div>
