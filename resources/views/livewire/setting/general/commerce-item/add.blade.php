<div class="px-4 pt-6">
    <x-jet-button wire:click="actionShowModal">
        {{ __('Add Commerce Item') }}
    </x-jet-button>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Commerce Item') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="sku" value="{{ __('SKU') }}" />
                    <x-jet-input id="sku" type="text" class="mt-1 block w-full" wire:model.debounce.800ms="sku"
                        autofocus />
                    <x-jet-input-error for="sku" class="mt-2" />
                </div>
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="name" value="{{ __('Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="name" autofocus />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="spec" value="{{ __('Spec') }}" />
                    <x-jet-input id="spec" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="spec" autofocus />
                    <x-jet-input-error for="spec" class="mt-2" />
                </div>
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="general_discount" value="{{ __('General Discount') }}" />
                    <x-jet-input id="general_discount" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="general_discount" autofocus />
                    <x-jet-input-error for="general_discount" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="fs_price" value="{{ __('FS Price') }}" />
                    <x-jet-input id="fs_price" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="fs_price" autofocus />
                    <x-jet-input-error for="fs_price" class="mt-2" />
                </div>
                <div class="col-span-12 sm:col-span-1 p-3">
                    <x-jet-label for="unit_price" value="{{ __('Unit Price') }}" />
                    <x-jet-input id="unit_price" type="text" class="mt-1 block w-full"
                        wire:model.debounce.800ms="unit_price" autofocus />
                    <x-jet-input-error for="unit_price" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="product_line" value="{{ __('Product Line') }}" />
                <select name="product_line" id="product_line"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debounce.800ms="product_line">
                    <option selected>-- Select Product Line --</option>
                    @foreach ($productLine as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="product_line" class="mt-2" />
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
