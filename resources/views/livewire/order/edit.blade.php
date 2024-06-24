<div>
    @if ($order->attachments)
        @foreach ($order->attachments as $file)
            <div class="bg-blue-100 border sm:rounded border-blue-500 text-blue-700 px-4 py-3 mb-4" role="alert">
                <div class="flex justify-between">
                    <span class="text-sm">Attachment:</span> <a
                        wire:click="actionShowModal('https://telixcel.s3.ap-southeast-1.amazonaws.com/{{ $file->file }}')"
                        href="#">Lihat</a>
                </div>
            </div>
        @endforeach

        <!-- Modal Detail -->
        <x-jet-dialog-modal wire:model="modalAttach">
            <x-slot name="title">
                <div class="text-center font-bold text-2xl">{{ __('Detail Pembayaran') }}</div>
            </x-slot>

            <x-slot name="content">
                <div class="p-4">
                    <div class="flex justify-between py-2">
                        <img src="{{ $url }}" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalAttach')" wire:loading.attr="disabled">
                    {{ __('x') }}
                </x-jet-secondary-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endif

    @if ($order->status == 'draft' || $order->status == 'unpaid' || $order->status == 'paid')
        <x-jet-form-section submit="updateStatus({{ $order->id }})">
            <x-slot name="title">
                {{ __('Status') }}
            </x-slot>

            <x-slot name="description">
                {{ __('The Customer basic information.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 grid grid-cols-2">
                    <div class="col-span-12 sm:col-span-1 mx-4">
                        <x-jet-label for="input.status" value="{{ __('Status') }}" />
                        <select name="input.status" id="input.status"
                            class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            wire:model.debunce.800ms="input.status">
                            <option selected>-- Select --</option>

                            @if ($order->status == 'draft')
                                <option value="draft">Draft</option>
                            @endif
                            @if ($order->status == 'unpaid' || $order->status == 'paid')
                                <option value="unpaid">Unpaid</option>
                                <option value="paid">Paid</option>
                                <option value="process">Process</option>
                                <option value="refund">Refund</option>
                            @endif
                            @if ($order->status == 'paid')
                                <option value="done">Done</option>
                            @endif

                        </select>
                        <x-jet-input-error for="input.status" class="mt-2" />
                    </div>

                </div>
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Order saved.') }}
                </x-jet-action-message>

                <x-save-button show="{{ $order->status == 'unpaid' ? true : false }}">
                    {{ __('Save') }}
                    </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    @endif

    <x-jet-section-border />

    <x-jet-form-section submit="update({{ $order->id }})">
        <x-slot name="title">
            {{ __('1. Order Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The basic information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="name" value="{{ __('Title') }}" />
                    <x-jet-input id="name" disabled="{{ disableInput($order->status) }}" type="text"
                        class="mt-1 block w-full" wire:model="input.name" wire:model.defer="name"
                        wire:model.debunce.800ms="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="no" value="{{ __('Order No') }}" />
                    <x-jet-input id="no" disabled="{{ disableInput($order->status) }}" type="text"
                        class="mt-1 block w-full" wire:model="input.no" wire:model.defer="input.no"
                        wire:model.debunce.800ms="input.no" />
                    <x-jet-input-error for="no" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="date" value="{{ __('Date') }}" />
                    <x-input.date-picker show="{{ disableInput($order->status) ? true : false }}"
                        wire:model="input.date" :error="$errors->first('input.date')" />
                    <x-jet-input-error for="date" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Order basic saved.') }}
            </x-jet-action-message>

            <x-save-button show="{{ $order->status == 'draft' ? true : false }}">
                {{ __('Save') }}
                </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="update({{ $order->id }},'customer')">
        <x-slot name="title">
            {{ __('2. Customer Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The Customer basic information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 grid grid-cols-2">
                <div class="col-span-12 sm:col-span-1 mx-4">
                    <x-jet-label for="input.customer_id" value="{{ __('Client') }}" />
                    <select {{ disableInput($order->status) ? 'disabled' : '' }} wire:change="onChangeModelId"
                        name="input.customer_id" id="input.customer_id"
                        class="border-gray-300 dark:bg-slate-800 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="input.customer_id">
                        <option selected>-- Select --</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach


                    </select>
                    <x-jet-input-error for="input.customer_id" class="mt-2" />
                </div>



                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="addressed_company" value="{{ __('Customer') }}" />
                    @if ($client)
                        @if ($client->user && $client->user_id == 0)
                            <div class="absolute p-3 ml-20" style=" margin-top: -35px; ">
                                <a href="{{ route('user.show', $client->user->id) }}" class="text-xs">view</a>
                            </div>
                        @endif
                        <span
                            class="border dark:bg-slate-800 rounded-md shadow-sm mt-1 block w-full p-2 capitalize">{{ $client->name }}</span>
                    @elseif ($customer)
                        @if ($customer)
                            <div class="absolute p-3 ml-20" style=" margin-top: -35px; ">
                                <a href="{{ route('user.show', $customer->id) }}" class="text-xs">view</a>
                            </div>
                        @endif

                        <span
                            class="border dark:bg-slate-800 rounded-md shadow-sm mt-1 block w-full p-2 capitalize">{{ $customer->name }}</span>

                    @endif

                    @if ($input['customer_id'] == 'new')
                        <div class="py-3">
                            @livewire('user.add', ['model' => 'order'])
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Order saved.') }}
            </x-jet-action-message>

            <x-save-button show="{{ $order->status == 'draft' ? true : false }}">
                {{ __('Save') }}
                </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    @livewire('order.item', ['data' => $order])

    <x-jet-section-border />

    @livewire('commission.edit', ['model' => 'order', 'data' => $order])

    @if ($order->status == 'draft')
        <x-jet-form-section submit="actionShowDeleteModal">
            <x-slot name="title">
                {{ __('Delete Order') }}
            </x-slot>

            <x-slot name="description">
                {{ __('This is for delete order.') }}
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
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Order saved.') }}
                </x-jet-action-message>

                <x-jet-button class="bg-red-600" wire:click="actionShowDeleteModal">
                    {{ __('Delete Order') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>

        <x-jet-dialog-modal class="text-left" wire:model="modalDeleteVisible">
            <x-slot name="title">
                {{ __('Delete Order') }}
            </x-slot>

            <x-slot name="content">
                <p>{{ __('Are you sure you want to delete this Order?') }}</p>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>

        <x-jet-section-border />

    @endif

</div>
