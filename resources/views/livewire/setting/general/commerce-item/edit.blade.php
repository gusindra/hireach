<div>
    <div>
        <x-jet-form-section submit="update({{ $commerceItem->id }})">
            <x-slot name="title">
                {{ __('Commerce Item Details') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Item information.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 grid grid-cols-2 gap-4">
                    <!-- SKU -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="sku" value="{{ __('SKU') }}" />
                        <x-jet-input id="sku" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.sku" autofocus />
                        <x-jet-input-error for="sku" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.name" autofocus />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 grid grid-cols-2 gap-4">
                    <!-- Spec -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="spec" value="{{ __('Spec') }}" />
                        <x-jet-input id="spec" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.spec" autofocus />
                        <x-jet-input-error for="spec" class="mt-2" />
                    </div>

                    <!-- General Discount -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="general_discount" value="{{ __('General Discount') }}" />
                        <x-jet-input id="general_discount" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.general_discount" autofocus />
                        <x-jet-input-error for="general_discount" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 grid grid-cols-2 gap-4">
                    <!-- FS Price -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="fs_price" value="{{ __('FS Price') }}" />
                        <x-jet-input id="fs_price" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.fs_price" autofocus />
                        <x-jet-input-error for="fs_price" class="mt-2" />
                    </div>

                    <!-- Unit Price -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="unit_price" value="{{ __('Unit Price') }}" />
                        <x-jet-input id="unit_price" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.unit_price" autofocus />
                        <x-jet-input-error for="unit_price" class="mt-2" />
                    </div>
                </div>
                <div class="col-span-6 grid grid-cols-2 gap-4">
                    <!-- FS Price -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="status" value="{{ __('Status') }}" />
                        <x-jet-input id="status" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.status" autofocus />
                        <x-jet-input-error for="status" class="mt-2" />
                    </div>

                    <!-- Unit Price -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="way_import" value="{{ __('Way Import') }}" />
                        <x-jet-input id="way_import" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.way_import" autofocus />
                        <x-jet-input-error for="way_import" class="mt-2" />
                    </div>
                </div>



                <div class="col-span-6 grid grid-cols-2 gap-4">

                    <div class="col-span-12 sm:col-span-1 p-3">
                        <!-- Product Line -->
                        <x-jet-label for="product_line" value="{{ __('Product Line') }}" />
                        <select name="product_line" id="product_line"
                            class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            wire:model.debounce.800ms="input.product_line">
                            <option value="">-- Select Product Line --</option>
                            @foreach ($productLines as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $input['product_line']) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="product_line" class="mt-2" />
                    </div>



                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="unit" value="{{ __('Units') }}" />
                        <x-jet-input id="unit" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.unit" autofocus />
                        <x-jet-input-error for="unit" class="mt-2" />
                    </div>
                </div>


                <div class="col-span-6 grid grid-cols-2 gap-4">
                    <!-- FS Desc -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="description" value="{{ __('Description') }}" />
                        <textarea id="description"
                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            rows="4" wire:model.debounce.800ms="input.description" autofocus></textarea>
                        <x-jet-input-error for="description" class="mt-2" />
                    </div>



                    <!-- Unit Price -->
                    <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="type" value="{{ __('Types') }}" />
                        <x-jet-input id="type" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.type" autofocus />
                        <x-jet-input-error for="type" class="mt-2" />
                    </div>
                </div>


                <!-- Additional fields can be added here similarly -->
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Product saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>

                <!-- Trigger the modal -->
                <x-jet-danger-button wire:click="modalAction" wire:loading.attr="disabled">
                    {{ __('Delete Product') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-form-section>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Delete Product') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this product? Once a product is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="modalAction" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete Product') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
