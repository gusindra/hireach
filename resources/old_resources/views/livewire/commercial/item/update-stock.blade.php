<div>
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border mb-4">
        <form wire:submit.prevent="updateStock({{$stock->id}})">
            <div class="flex-auto p-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 font-bold dark:text-white shrink-0 flex justify-between mb-4">
                        <select
                            name="warehouseId"
                            id="warehouseId"
                            class="focus:shadow-soft-primary-outline text-lg font-bold dark:text-white dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 leading-5.6 ease-soft block w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                            wire:model.debunce.800ms="warehouseId" choice name="choices-category"
                            >
                            @foreach ($warehouses as $house)
                                <option {{$warehouseId==$house->id?'selected':''}} value="{{$house->id}}">{{$house->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-3/12 max-w-full px-3 flex-0">
                        <x-jet-label for="avaiable" value="{{ __('Stock') }}" class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                        <x-jet-input id="avaiable" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" wire:model.debunce.800ms="avaiable" autofocus />
                        <x-jet-input-error for="avaiable" class="mt-2" />
                    </div>
                    <div class="w-3/12 max-w-full px-3 flex-0">
                        <x-jet-label for="price" value="{{ __('Price') }}" class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                        <x-jet-input id="price" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" wire:model.debunce.800ms="price" autofocus />
                        <x-jet-input-error for="price" class="mt-2" />
                    </div>
                    <div class="w-5/12 max-w-full px-3 flex-0">
                        <x-jet-label for="sku" value="{{ __('Unit SKU') }}" class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                        <x-jet-input id="sku" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" wire:model.debunce.800ms="sku" autofocus />
                        <x-jet-input-error for="sku" class="mt-2" />
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mt-6">
                    <div class="w-3/12 max-w-full px-3 flex-0">
                        <x-jet-label for="length" value="{{ __('Length') }}" class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                        <x-jet-input id="length" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" wire:model.debunce.800ms="length" autofocus />
                        <x-jet-input-error for="length" class="mt-2" />
                    </div>
                    <div class="w-3/12 max-w-full px-3 flex-0">
                        <x-jet-label for="height" value="{{ __('Height') }}" class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                        <x-jet-input id="height" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" wire:model.debunce.800ms="height" autofocus />
                        <x-jet-input-error for="height" class="mt-2" />
                    </div>
                    <div class="w-3/12 max-w-full px-3 flex-0">
                        <x-jet-label for="width" value="{{ __('Width') }}" class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                        <x-jet-input id="width" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" wire:model.debunce.800ms="width" autofocus />
                        <x-jet-input-error for="width" class="mt-2" />
                    </div>
                    <div class="w-3/12 max-w-full px-3 flex-0">
                        <x-jet-label for="weight" value="{{ __('Weight') }}" class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                        <x-jet-input id="weight" type="text" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" wire:model.debunce.800ms="weight" autofocus />
                        <x-jet-input-error for="weight" class="mt-2" />
                    </div>
                </div>
                <div class="w-full max-w-full mt-4 flex-0">
                    <div class="flex flex-row-reverse">
                        <x-jet-button class="inline-block px-8 py-2 mr-2 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                            {{ __('Update') }}
                        </x-jet-button>
                        <x-jet-action-message class="mr-3 my-auto" on="saved">
                            {{ __('Stock updated.') }}
                        </x-jet-action-message>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
