<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{ __('Add Contact') }}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Contact') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-3 grid grid-cols-3 gap-2 space-y-2 p-2">
                <div class="col-span-12 sm:col-span-1 mt-2">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <select name="title" id="title"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="input.title">
                        <option selected>-- Select --</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Miss">Miss</option>
                        <option value="Ms.">Ms.</option>
                        <option value="PT.">PT.</option>
                        <option value="CV.">CV.</option>
                        <option value="none">None</option>
                    </select>
                    <x-jet-input-error for="title" class="mt-2" />
                </div>
                <div class="col-span-12 sm:col-span-2">
                    <x-jet-label for="input.name" value="{{ __('Name') }}" />
                    <x-jet-input id="client_name" type="text" class="mt-1 block w-full" wire:model="input.name"
                        wire:model.defer="input.name" wire:model.debunce.800ms="input.name" />
                    <x-jet-input-error for="input.name" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="input.email" value="{{ __('Email') }}" />
                <x-jet-input autocomplete="off" id="input.email" type="text" class="mt-1 block w-full"
                    wire:model.debunce.800ms="input.email" autofocus />
                <x-jet-input-error for="input.email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="input.phone" value="{{ __('Phone') }}" />
                <x-jet-input autocomplete="off" id="input.phone" type="text" class="mt-1 block w-full"
                    wire:model.debunce.800ms="input.phone" autofocus />
                <x-jet-input-error for="input.phone" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
