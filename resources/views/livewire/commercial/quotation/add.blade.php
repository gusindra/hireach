<div>
    <x-jet-button wire:click="actionShowModal">
        Add Quotation
    </x-jet-button>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Quotation') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="price" value="{{ __('Type') }}" />
                <select name="type" id="type"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="type">
                    <option selected>-- Select --</option>

                    <option value="price">Price & Discount</option>

                </select>
                <x-jet-input-error for="price" class="mt-2" />
            </div>

            <div>
                <x-jet-label for="source" value="{{ __('Customer') }}" />
                <select name="source" id="source"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="source">
                    <option value="" selected>-- Select --</option>
                    @foreach ($users as $user)
                        @if (!$user->isSuper)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
                <x-jet-input-error for="source" class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="title"
                    autofocus />
                <x-jet-input-error for="title" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="date" value="{{ __('Quotation Date') }}" />
                <x-input.date-picker wire:model="date" :error="$errors->first('date')" />
                <x-jet-input-error for="date" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="valid_day" value="{{ __('Duration') }}" />
                <select name="valid_day" id="valid_day"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model='valid_day' wire:model.debunce.800ms="valid_day">
                    <option selected>-- Select --</option>
                    <option value="3">3 days</option>
                    <option value="7">7 days</option>
                    <option value="30">30 days</option>
                    <option value="60">60 days</option>
                </select>
                <x-jet-input-error for="price" class="mt-2" />
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
