<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{__('Import Contact')}}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Contact') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-3 grid grid-cols-3 gap-2 space-y-2 p-2">
                <form action="{{ route('contact.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" accept=".csv">
                    <button type="submit">Import CSV</button>
                </form>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>

