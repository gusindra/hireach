<div class="px-4 pt-6">
    <div class="flex justify-between">
        <h1 class="font-bold">Group Product</h1>
        <x-add-button :disabled="!userAccess('SETTING', 'create')" wire:click="actionShowModal">
            {{ __('Add Product Line') }}
        </x-add-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Product Line') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="name" autofocus />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="company_id" value="{{ __('Company') }}" />
                    <select name="company_id" id="company_id"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debounce.800ms="company_id">
                        <option selected>-- Select Company --</option>
                        @foreach ($company as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="company_id" class="mt-2" />
                </div>
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
