<div>
    <div class="relative flex flex-col p-6 min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
        @livewire('commercial.product-lines', ['model' => 'product', 'data' => $item])
    </div>
    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3 shrink-0 lg:flex-0 lg:w-4/12">
            <div
                class="relative flex flex-col h-full min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-6">
                    <h5 class="font-bold dark:text-white">Product Image</h5>
                    <div class="flex flex-wrap -mx-3">
                        @livewire('image-upload', ['model'=> 'product', 'model_id'=>$item->id])
                        <div class="w-full max-w-full px-3 mt-6 flex-0">
                            <div class="flex">
                                <button type="button"
                                    class="inline-block px-8 py-2 mr-2 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">Edit</button>
                                <button type="button"
                                    class="inline-block px-8 py-2 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft bg-150 bg-x-25 hover:scale-102 active:shadow-soft-xs border-slate-700 dark:border-white dark:text-white dark:hover:text-white dark:active:border-white dark:hover:active:border-white dark:active:hover:text-white text-slate-700 hover:text-slate-700 hover:opacity-75 hover:shadow-none active:scale-100 active:border-slate-700 active:bg-slate-700 active:text-white hover:active:border-slate-700 hover:active:text-slate-700 hover:active:opacity-75">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full max-w-full px-3 mt-6 shrink-0 lg:flex-0 lg:w-8/12 lg:mt-0">
            <form wire:submit.prevent="update({{$item->id}})">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-6">
                        <h5 class="font-bold dark:text-white">Product Master Information</h5>
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-6/12 max-w-full px-3 flex-0">
                                <x-jet-label for="status" value="{{ __('Status') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <select
                                    name="status"
                                    id="status"
                                    class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                    wire:model.debunce.800ms="status" choice name="choices-category"
                                    >
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                    <option value="compleated">Disabled</option>
                                </select>
                                <x-jet-input-error for="status" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 flex-0 sm:w-6/12">
                                <x-jet-label for="name" value="{{ __('Product Name') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80"/>
                                <x-jet-input id="name"
                                            type="text"
                                            class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                            wire:model="name"
                                            wire:model.defer="name"
                                            wire:model.debunce.800ms="name" />
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>
                            <div class="w-full max-w-full px-3 mt-4 flex-0 sm:w-6/12 sm:mt-0">
                                <x-jet-label for="sku" value="{{ __('Master SKU') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <x-jet-input id="sku"
                                            type="text"
                                            class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                            wire:model="sku"
                                            wire:model.defer="sku"
                                            wire:model.debunce.800ms="sku" />
                                <x-jet-input-error for="sku" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-6/12 max-w-full px-3 flex-0">
                                <x-jet-label for="price" value="{{ __('Price') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <x-jet-input id="price"
                                            type="text"
                                            class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                            wire:model="price"
                                            wire:model.defer="price"
                                            wire:model.debunce.800ms="price" />
                                <x-jet-input-error for="price" class="mt-2" />
                            </div>
                            <div class="w-6/12 max-w-full px-3 flex-0">
                                <x-jet-label for="discount" value="{{ __('General Discount') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <x-jet-input id="discount"
                                            type="text"
                                            class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                            wire:model="discount"
                                            wire:model.defer="discount"
                                            wire:model.debunce.800ms="discount" />
                                <x-jet-input-error for="discount" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3">
                            <div class="w-6/12 max-w-full px-3 flex-0">
                                <x-jet-label for="type" value="{{ __('Type') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <select
                                    name="type"
                                    id="type"
                                    class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                    wire:model.debunce.800ms="type"
                                    >
                                    <option selected>-- Select Party --</option>
                                    <option value="sku">SKU</option>
                                    <option value="nosku">Without SKU</option>
                                    <option value="one_time">One Time Service</option>
                                    <option value="monthly">Monthly Service</option>
                                    <option value="anually">Yearly Service</option>
                                </select>
                                <x-jet-input-error for="type" class="mt-2" />
                            </div>
                            @if($type=='sku' || $type=='nosku')
                            <div class="w-6/12 max-w-full px-3 flex-0">
                                <x-jet-label for="type" value="{{ __('Import') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <select
                                    name="import"
                                    id="import"
                                    class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                                    wire:model.debunce.800ms="import"
                                    >
                                    <option value="none">None</option>
                                    <option value="fob">FOB (Free on Board)</option>
                                    <option value="ddp">DDP (Delivered Duty Paid)</option>
                                </select>
                                <x-jet-input-error for="import" class="mt-2" />
                            </div>
                            @endif
                        </div>

                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 flex-0">
                                <x-jet-label for="description" value="{{ __('Description') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <x-textarea wire:model="description"
                                            wire:model.defer="description"
                                            value="description" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none h-40"></x-textarea>
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 flex-0">
                                <x-jet-label for="spec" value="{{ __('Specification') }}" class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80" />
                                <x-textarea wire:model="spec"
                                            wire:model.defer="spec"
                                            value="spec" class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none h-40"></x-textarea>
                                <x-jet-input-error for="name" class="mt-2" />
                            </div>
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 my-4 flex-0">
                        <div class="flex flex-row-reverse">
                            <x-jet-button class="inline-block px-8 py-2 mr-2 text-xs font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer ease-soft-in leading-pro tracking-tight-soft bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85">
                                {{ __('Save') }}
                            </x-jet-button>
                            <x-jet-action-message class="mr-3 my-auto" on="product_saved">
                                {{ __('Product saved.') }}
                            </x-jet-action-message>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3 shrink-0 sm:flex-0 sm:w-4/12">
            <div
                class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-6">
                    <h5 class="font-bold dark:text-white">Selling Channel</h5>
                    <label class="mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80"
                        for="Shoppify Handle">Instagram</label>
                    <input type="text" name="Shoppify Handle" placeholder="@soft"
                        class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                    <label class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80"
                        for="Shoppify Handle">Website URL</label>
                    <input type="text" name="Shoppify Handle" placeholder="https://..."
                        class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                    <label class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80"
                        for="Facebook Account">Tokopedia</label>
                    <input type="text" name="Facebook Account" placeholder="https://..."
                        class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                    <label class="mt-6 mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80"
                        for="Instagram Account">Shopee</label>
                    <input type="text" name="Instagram Account" placeholder="https://..."
                        class="focus:shadow-soft-primary-outline dark:bg-gray-950 dark:placeholder:text-white/80 dark:text-white/80 text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                </div>
            </div>
        </div>
        <div class="w-full max-w-full px-3 mt-6 shrink-0 sm:flex-0 sm:w-8/12 sm:mt-0">
            @if($type=='sku' || $type=='nosku')
                @foreach($item->stock as $stok)
                    @livewire('commercial.item.update-stock', ['code'=>$stok->id])
                @endforeach
                @livewire('commercial.item.add-stock', ['productId'=>$item->id])
            @endif
        </div>
    </div>
</div>
