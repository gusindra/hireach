<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{ __('Search Contact') }}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Search Contact') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="search" value="{{ __('Client Name / Email / Phone') }}" />
                <x-jet-input autocomplete="off" id="search" type="text" class="mt-1 block w-full"
                    wire:model.debunce.800ms="search" autofocus />
                <x-jet-input-error for="search" class="mt-2" />
            </div>
            @if(!empty($data))
                <div class="relative overflow-x-auto">
                    @if($data->count())
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Client ID</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Contact</th>
                                    <th scope="col" class="px-6 py-3">Owner</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($data as $d)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <x-jet-input x-ref="plaintextToken" type="text" readonly :value="$d->id"
                                                    class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full"
                                                    autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                                                />
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$d->name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$d->email}} / {{$d->phone}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$d->theUser->name}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    @else
                        <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <div class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-center">
                                No Result
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </x-slot>

        <x-slot name="footer">
            <!-- <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="create()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button> -->
        </x-slot>
    </x-jet-dialog-modal>
</div>
