<div>
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-3 text-center">
            <div class="flex flex-wrap -mx-3">
                <a wire:click="actionShowModal" class="w-full max-w-full px-3 dark:text-white shrink-0 cursor-pointer">+ New Stock Warehouse</a>
            </div>
        </div>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Warehouse Stock') }}
        </x-slot>

        <x-slot name="content">
        @if(count($warehouses)>0)
            <div class="col-span-6 sm:col-span-4 p-3 mx-2">
                <select
                    name="warehouseId"
                    id="warehouseId"
                    class="focus:shadow-soft-primary-outline text-lg font-bold dark:text-white dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 leading-5.6 ease-soft block w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                    wire:model.debunce.800ms="warehouseId" choice name="choices-category"
                    >
                    <option value="0">Select Warehouse</option>
                    @foreach ($warehouses as $house)
                        <option {{$warehouseId==$house->id?'selected':''}} value="{{$house->id}}">{{$house->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-6 sm:col-span-4 p-3 flex">
                <div class="mx-2">
                    <x-jet-label for="stock" value="{{ __('Stock') }}" />
                    <x-jet-input id="stock" type="number" class="mt-1 block w-full" wire:model.debunce.800ms="addStock" autofocus />
                    <x-jet-input-error for="stock" class="mt-2" />
                </div>
                <div class="mx-2">
                    <x-jet-label for="price" value="{{ __('Price') }}" />
                    <x-jet-input id="price" type="number" class="mt-1 block w-full" wire:model.debunce.800ms="addPrice" autofocus />
                    <x-jet-input-error for="price" class="mt-2" />
                </div>
                <div class="mx-2">
                    <x-jet-label for="sku" value="{{ __('Unit SKU') }}" />
                    <x-jet-input id="sku" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="addSku" autofocus />
                    <x-jet-input-error for="sku" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-4 p-3 flex">
                <div class="mx-2">
                    <x-jet-label for="length" value="{{ __('Length') }}" />
                    <x-jet-input id="length" type="number" class="mt-1 block w-full" wire:model.debunce.800ms="addLength" autofocus />
                    <x-jet-input-error for="length" class="mt-2" />
                </div>
                <div class="mx-2">
                    <x-jet-label for="height" value="{{ __('Height') }}" />
                    <x-jet-input id="height" type="number" class="mt-1 block w-full" wire:model.debunce.800ms="addHeight" autofocus />
                    <x-jet-input-error for="height" class="mt-2" />
                </div>
                <div class="mx-2">
                    <x-jet-label for="width" value="{{ __('Width') }}" />
                    <x-jet-input id="width" type="number" class="mt-1 block w-full" wire:model.debunce.800ms="addWidth" autofocus />
                    <x-jet-input-error for="width" class="mt-2" />
                </div>
                <div class="mx-2">
                    <x-jet-label for="weight" value="{{ __('Weight') }}" />
                    <x-jet-input id="weight" type="number" class="mt-1 block w-full" wire:model.debunce.800ms="addWeight" autofocus />
                    <x-jet-input-error for="weight" class="mt-2" />
                </div>
            </div>
        @else
            Add another Warehouse ?
        @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
            @livewire('commercial.item.add-warehouse')
        </x-slot>
    </x-jet-dialog-modal>
</div>
