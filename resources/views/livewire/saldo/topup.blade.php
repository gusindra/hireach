<div>
    <div class="flex items-center text-right">
        <a wire:click="actionShowModal" class="inline-flex items-center px-2 py-1 bg-green-800 border border-transparent rounded-sm font-normal text-xs text-white 1g-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition" wire:click="actionShowModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('New Topup') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="team" value="{{ __('Team') }}" />
                <select
                    name="team"
                    id="team"
                    class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="team"
                    >
                    <option value="">All Team</option>
                    @foreach ($user->teams as $team)
                    <option value="{{$team->id}}">{{$team->name}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="team" class="mt-2" />
            </div>
            <div class="flex">
                <div class="col-span-6 sm:col-span-4 p-3">
                    <x-jet-label for="mutation" value="{{ __('Mutation') }}" />
                    <select
                        name="mutation"
                        id="mutation"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="mutation"
                        >
                        <option value="" selected>-- Select --</option>
                        <option value="credit">Credit - Topup</option>
                        <option value="debit" selected>Debit - Biaya keluar</option>
                    </select>
                    <x-jet-input-error for="mutation" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 p-3">
                    <x-jet-label for="currency" value="{{ __('Currency') }}" />
                    <select
                        name="currency"
                        id="currency"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="currency"
                        >
                        <option value="" selected>-- Select --</option>
                        <option value="idr" selected>IDR - Rupiah</option>
                        <!-- <option value="usd">USD - US Dollar</option> -->
                    </select>
                    <x-jet-input-error for="currency" class="mt-2" />
                </div>
                <div class="col-span-6 sm:col-span-4 p-3">
                    <x-jet-label for="amount" value="{{ __('Amount') }}" />
                    <x-jet-input id="amount" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="amount" autofocus />
                    <x-jet-input-error for="amount" class="mt-2" />
                </div>
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="description" autofocus />
                <x-jet-input-error for="description" class="mt-2" />
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
