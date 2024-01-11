<div>
    <!-- <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" href="{{route('create.template')}}">
        {{ __('Create') }}
    </a> -->
    <div>
        <a wire:click="actionShowModal">
            {{__('New Project')}}
        </a>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Project') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <select
                    name="type"
                    id="type"
                    class="px-3 py-2 border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="type"
                    >
                    <option selected>-- Select Type --</option>
                    <option value="selling">Selling Product / Annexed Service</option>
                    <option value="saas">SAAS Service</option>
                    <option value="referral">Referral</option>
                </select>
                <x-jet-input-error for="type" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="name" value="{{ __('Project Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="name" autofocus />
                <x-jet-input-error for="name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="name" value="{{ __('Customer') }}" />
                <div class="">
                    <div class="form-check form-check-inline">
                        <input wire:model="customer" class="-4 w-4 border border-gray-300 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="exists">
                        <label class="form-check-label inline-block text-gray-800" for="inlineRadio20"><span class="font-sm">Select from Exsisting Customers</span></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input wire:model="customer" class="-4 w-4 border border-gray-300 transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="new">
                        <label class="form-check-label inline-block text-gray-800" for="inlineRadio10"><span class="font-sm">New Customer</span></label>
                    </div>
                </div>
                <x-jet-input-error for="customer" class="mt-2" />
                @if($customer=="exists")
                <select
                    name="customer_type"
                    id="customer_type"
                    class="px-3 py-2 border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="customer_type"
                    >
                    <option selected>-- Select Customer --</option>
                    @foreach ($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                    <option value="new">Add New Customer</option>
                </select>
                <x-jet-input-error for="customer_type" class="mt-2" />
                @endif
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Create') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

