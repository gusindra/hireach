<div>
    <x-jet-button wire:click="actionShowModal">
        Add Order
    </x-jet-button>
    <div class="flex items-center text-right">
        <a
            class="ml-2 cursor-pointer hidden inline-flex items-center px-2 py-1 bg-green-800 border border-transparent rounded-sm font-normal text-xs text-white 1g-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">
            {{ __('Import Order') }}
        </a>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Order') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="entity" value="{{ __('Entity of Party B') }}" />
                <select name="entity" id="entity"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="entity">
                    <option selected>-- Select Party --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="entity" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input autocomplete="off" id="name" type="text" class="mt-1 block w-full"
                    wire:model.debunce.800ms="name" autofocus />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="customer_id" value="{{ __('Customer') }}" />
                <select name="customer_id" id="customer_id"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="customer_id">
                    <option selected>-- Select Customer --</option>
                    @foreach ($customer as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="customer_id" class="mt-2" />
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
