<div>
    <div class="flex justify-between items-center p-4 rounded-md {{!$billing?'bg-yellow-200 animate-pulse':''}}">
        <div class="text-left w-full {{!$billing?'flex justify-between':''}}">
            @if ($billing)
                @if($type=='prepaid')
                    <div>PREPAID</div>
                    <div class="px-6 py-4 mx-auto my-3 rounded-lg shadow">
                        @livewire('saldo.topup', ['user' => $user, 'id' => $userId])
                    </div>
                @else
                    <p class="text-base font-bold">POSTPAID</p>
                    Yang Harus Dibayarkan Adalah: {{ 'Rp ' . number_format(abs($postPaid->balance), 0, ',', '.') }}
                @endif
            @else
                <p class="text-base">User ini belum memilih <b>Type Billing</b>. Silahkan setting terlebih dahulu agar dapat menentukan penagihan saat service digunakan.</p>
                <div class="text-right">
                    <x-link-button class="" wire:click="actionShowModal">
                        {{__("Add Billing Type")}}
                    </x-link-button>
                </div>
            @endif
        </div>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Set Type Billing User') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="type" value="{{ __('Billing Type') }}" />
                <select name="type" id="type"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="type">
                        <option value="" selected>-- Select --</option>
                        <option value="prepaid">PrePaid</option>
                        <option value="postpaid" selected>PostPaid</option>
                    </select>
                <x-jet-input-error for="type" class="mt-2" />
            </div>

            <div class="col-span-12">
                <div class="grid grid-cols-4 gap-4 p-3">
                    <div class="col-span-2">
                        <x-jet-label for="name" value="{{ __('Full Name') }}" />
                        <x-jet-input id="name" type="text" class="mt-1 block w-full"
                            wire:model.debunce.800ms="name" autofocus />
                        <x-jet-input-error for="name" class="mt-2" />
                    </div>
                    <div class="col-span-2">
                        <x-jet-label for="tax" value="{{ __('No NPWP') }}" />
                        <x-jet-input id="tax" type="text" class="mt-1 block w-full"
                            wire:model.debunce.800ms="tax" autofocus />
                        <x-jet-input-error for="tax" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 p-3">
                    <div class="col-span-1">
                        <x-jet-label for="province" value="{{ __('Province') }}" />
                        <x-jet-input id="province" type="text" class="mt-1 block w-full"
                            wire:model.debunce.800ms="province" autofocus />
                        <x-jet-input-error for="province" class="mt-2" />
                    </div>
                    <div class="col-span-1">
                        <x-jet-label for="city" value="{{ __('City') }}" />
                        <x-jet-input id="city" type="text" class="mt-1 block w-full"
                            wire:model.debunce.800ms="city" autofocus />
                        <x-jet-input-error for="city" class="mt-2" />
                    </div>
                    <div class="col-span-1">
                        <x-jet-label for="postcode" value="{{ __('Post Code') }}" />
                        <x-jet-input id="postcode" type="text" class="mt-1 block w-full"
                            wire:model.debunce.800ms="postcode" autofocus />
                        <x-jet-input-error for="postcode" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-1 p-3">
                    <x-jet-label for="address" value="{{ __('Address') }}" />
                    <x-jet-input id="address" type="text" class="mt-1 block w-full"
                        wire:model.debunce.800ms="address" autofocus />
                    <x-jet-input-error for="address" class="mt-2" />
                </div>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button :disabled="!userAccess('USER', 'create')" class="ml-2" wire:click="create" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
