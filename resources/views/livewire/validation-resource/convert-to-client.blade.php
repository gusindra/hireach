<div>
    <x-jet-button wire:click="showModal" class="btn btn-primary">Sync</x-jet-button>
    <x-jet-dialog-modal wire:model.defer="showModal">
        <x-slot name="title">
            Convert to Client
        </x-slot>

        <x-slot name="content">
            <div>
                <x-jet-button wire:click="addAllDataNoHp" class="btn btn-success">To New Client</x-jet-button>
                <x-jet-button wire:click="addAllClientIds" class="btn btn-info">Validate Client</x-jet-button>
                <x-jet-button wire:click="performAllActions" class="btn btn-danger">Sync All</x-jet-button>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="hideModal">
                Close
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
