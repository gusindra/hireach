<div>

    <div class="hidden">
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

                    {{-- <div class="col-span-12 sm:col-span-1 p-3">
                        <x-jet-label for="way_import" value="{{ __('Way Import') }}" />
                        <x-jet-input id="way_import" type="text" class="mt-1 block w-full"
                            wire:model.debounce.800ms="input.way_import" autofocus />
                        <x-jet-input-error for="way_import" class="mt-2" />
                    </div> --}}
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
                <x-jet-danger-button :disabled="!userAccess('SETTING', 'delete')" wire:click="modalAction" wire:loading.attr="disabled">
                    {{ __('Delete Product') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-form-section>
    </div>
    @foreach ($errors as $error)
        <span>{{ $error }}</span>
    @endforeach

    @livewire('commercial.product-lines', ['model' => 'product', 'data' => $commerceItem])

    <x-jet-form-section submit="update({{ $commerceItem->id }})">
        <x-slot name="title">
            {{ __('Basic') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The Product basic information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4"> 
                <x-jet-label for="type" value="{{ __('Status') }}" />
                <select name="status" id="status"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="input.status">
                    <option selected>-- Select Status --</option>
                    <option value="null">Draft</option>
                    <option value="1">Active</option>
                    <option value="0">Disabled</option>
                </select>
                <x-jet-input-error for="input.status" class="mt-2" /> 
            </div>
            <div class="col-span-6 sm:col-span-4"> 
                <x-jet-label for="sku" value="{{ __('SKU') }}" />
                <x-jet-input id="sku" type="text" class="mt-1 block w-full" wire:model="input.sku"
                    wire:model.defer="input.sku" wire:model.debunce.800ms="input.sku" />
                <x-jet-input-error for="input.sku" class="mt-2" /> 
            </div>
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <select name="type" id="type"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="input.type">
                    <option selected>-- Select Party --</option>
                    <option value="sku">SKU</option>
                    <option value="nosku">Without SKU</option>
                    <option value="one_time">One Time Service</option>
                    <option value="monthly">Monthly Service</option>
                    <option value="anually">Yearly Serivce</option>
                </select>
                <x-jet-input-error for="input.type" class="mt-2" />
            </div>

            {{-- <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="import" value="{{ __('Import') }}" />
                <select name="import" id="import"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="input.way_import">
                    <option selected>-- Select Import Way --</option>
                    <option value="none">None</option>
                    <option value="fob">FOB (Free on Board)</option>
                    <option value="ddp">DDP (Delivered Duty Paid)</option>
                </select>
                <x-jet-input-error for="input.way_import" class="mt-2" />
            </div> --}}

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Product saved.') }}
            </x-jet-action-message>

            <x-jet-button :disabled="!userAccess('SETTING', 'update')">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="update({{ $commerceItem->id }})">
        <x-slot name="title">Description</x-slot>

        <x-slot name="description">
            {{ __('The Product detail.') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="name" value="{{ __('Product Name') }}" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="input.name"
                        wire:model.defer="input.name" wire:model.debunce.800ms="input.name" />
                    <x-jet-input-error for="input.name" class="mt-2" />
                </div>
            </div>
            <!-- Description -->
            <div class="col-span-6 sm:col-span-6">
                <x-jet-label for="description" value="{{ __('Description') }}" />

                <x-textarea wire:model="input.description" wire:model.defer="input.description" value="description"
                    wire:model.debounce.800ms="input.description" class="mt-1 block w-full"></x-textarea>
                <x-jet-input-error for="input.description" class="mt-2" />
            </div>
            <!-- Specification -->
            <div class="col-span-6 sm:col-span-6">
                <x-jet-label for="spec" value="{{ __('Specification') }}" />

                <x-textarea wire:model="input.spec" wire:model.debounce.800ms="input.spec"
                    wire:model.defer="input.spec" value="spec" class="mt-1 block w-full"></x-textarea>
                <x-jet-input-error for="input.spec" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Product saved.') }}
            </x-jet-action-message>

            <x-jet-button :disabled="!userAccess('SETTING', 'update')">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="update({{ $commerceItem->id }})">
        <x-slot name="title">Price</x-slot>

        <x-slot name="description">
            {{ __('Unit price / listing price.') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="price" value="{{ __('Price') }}" />
                    <x-jet-input id="price" type="text" class="mt-1 block w-full"
                        wire:model="input.unit_price" wire:model.defer="input.unit_price"
                        wire:model.debunce.800ms="input.unit_price" />
                    <x-jet-input-error for="input.unit_price" class="mt-2" />
                </div>
                @if ($item->type == 'nosku')
                    <div class="col-span-10 sm:col-span-1 mx-4">
                        <x-jet-label for="unit" value="{{ __('Unit') }}" />
                        <x-jet-input id="unit" type="text" class="mt-1 block w-full" wire:model="input.unit"
                            wire:model.defer="input.unit" wire:model.debunce.800ms="input.unit" />
                        <x-jet-input-error for="input.unit" class="mt-2" />
                    </div>
                @endif
            </div>

            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="discount" value="{{ __('General Discount') }}" />
                    <x-jet-input id="discount" type="text" class="mt-1 block w-full"
                        wire:model="input.general_discount" wire:model.defer="input.general_discount"
                        wire:model.debunce.800ms="input.general_discount" />
                    <x-jet-input-error for="input.general_discount" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Product saved.') }}
            </x-jet-action-message>

            <x-jet-button :disabled="!userAccess('SETTING', 'update')" class="bg-red-600">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <div class="md:grid md:grid-cols-5 md:gap-6">
        <div class="md:col-span-1 flex justify-between">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-300">Pics</h3>

                <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">
                    The Product picture.
                </p>
            </div>

            <div class="px-4 sm:px-0"> </div>
        </div>

        <div class="mt-0 md:mt-0 md:col-span-4">
            <div class=" bg-white dark:bg-slate-600 shadow sm:rounded-md">
                <div class="">
                    @livewire('image-upload', ['model' => 'product', 'model_id' => $commerceItem->id])
                </div>
            </div>
        </div>
    </div>

    <x-jet-section-border />
    <div class="hidden">
        @livewire('commission.edit', ['model' => 'product', 'data' => $commerceItem])
    </div>

    <x-jet-form-section submit="modalAction">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="description">
            {{ __('This is for delete Item.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 mx-4 text-right">
                </div>
                <div class="col-span-12 sm:col-span-1 mx-4 text-right">
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-button :disabled="!userAccess('SETTING', 'delete')" class="bg-red-600" wire:click="modalAction">
                {{ __('Delete Item') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <!-- Delete Confirmation Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item? Once a product is deleted, all of its resources and data will be permanently deleted.') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('Delete Item') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
