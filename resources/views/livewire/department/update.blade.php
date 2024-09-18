<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{ __('Update Department') }}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Update Department') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="server" value="{{ __('Server') }}" />
                <x-jet-input autocomplete="off" id="server" type="text" class="mt-1 block w-full" list="server"
                    wire:model.debunce.800ms="server" autofocus />
                    <datalist id="server">
                        @foreach($servers as $key => $server)
                            <option value="{{$key}}">
                        @endforeach
                    </datalist>
                <x-jet-input-error for="server" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="update()" wire:loading.attr="disabled">
                {{ __('Update') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
