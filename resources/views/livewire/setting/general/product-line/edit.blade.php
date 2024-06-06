<div>
    <div>
        <x-jet-form-section submit="updateProductLine({{ $productLine->id }})">
            <x-slot name="title">
                {{ __('1. Product Line Details') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Product line information.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="product_line_id" value="{{ __('Product Line ID') }}" />
                        <p>{{ $productLine->id }}</p>
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="input.name"
                            wire:model.defer="input.name" wire:model.debounce.800ms="input.name" />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="type" value="{{ __('Type') }}" />
                        <x-jet-input id="type" type="text" class="mt-1 block w-full" wire:model="input.type"
                            wire:model.defer="input.type" wire:model.debounce.800ms="input.type" />
                        <x-jet-input-error for="type" class="mt-2" />
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div class="col-span-12 sm:col-span-1">
                        <x-jet-label for="company_id" value="{{ __('Company') }}" />
                        <select
                            class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            id="company_id" class="mt-1 block w-full form-select" wire:model="input.company_id"
                            wire:model.defer="input.company_id" wire:model.debounce.800ms="input.company_id">
                            <option value="">{{ __('Select a Company') }}</option>
                            @foreach ($company as $item)
                                <option value="{{ $item->id }}" @if ($item->id == $input['company_id']) selected @endif>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="company_id" class="mt-2" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Product Line saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>

        <x-jet-section-border />

        <!-- Trigger the modal -->
        <x-jet-form-section submit="modalAction">
            <x-slot name="title">
                {{ __('Delete Product Line') }}
            </x-slot>

            <x-slot name="description">
                {{ __('This is for delete Product Line.') }}
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
                <x-jet-button class="bg-red-600" wire:click="modalAction">
                    {{ __('Delete Product Line') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>

        <x-jet-dialog-modal wire:model="modalActionVisible">
            <x-slot name="title">
                {{ __('Delete Product Line') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this product line? Once a product line is deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete Product Line') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>

    </div>
</div>
