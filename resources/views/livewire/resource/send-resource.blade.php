<div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="bg-indigo-600 mb-4">
        <div class="w-full mx-auto p-3 px-3">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center">
                    <span class="flex p-2 rounded-lg bg-indigo-800">
                        <!-- Heroicon name: outline/speakerphone -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <p class="ml-3 font-medium text-white truncate">
                        <span class="md:hidden">
                            Respond Question
                        </span>
                        <span class="hidden md:inline">
                            This template is use for respond question {{ $resource }} Way.
                        </span>
                    </p>
                </div>
                <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                    <button type="button"
                        class="flex items-center my-auto p-3 text-xs text-white bg-indigo-800 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white"
                        wire:click="sendResource">
                        SEND
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="ml-2 w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </button>

                </div>
            </div>
        </div>
    </div>

    {{-- Channel Information --}}
    <x-jet-form-section submit="updateTemplate">
        <x-slot name="title">
            {{ __('Channel') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The Channel information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 grid grid-cols-5">
                <!-- Type Information -->
                <div class="col-span-1">
                    <x-jet-label class="capitalize text-xs" value="type" />
                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-base">
                                    Manual Template
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <x-jet-label for="name" value="{{ __('Created By') }}" />
                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-base capitalize">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <x-jet-label for="name" value="{{ __('Created At') }}" />
                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-base ">
                                    {{ date('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 p-3 bg-gray-100 border-1 rounded-lg space-y-3">
                @if ($resource == 2)
                    <!-- Template Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="bound" value="{{ __('Bound') }}" />
                        <select name="bound" id="bound"
                            class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            wire:model.debunce.800ms="bound">
                            <option selected>-- Select bound --</option>
                            <option value="out">Out</option>
                            <option value="in">In</option>
                        </select>
                        <x-jet-input-error for="bound" class="mt-2" />
                    </div>
                @endif
                <!-- Template Name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="channel" value="{{ __('Channel') }}" />
                    <select name="channel" id="channel"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="channel">
                        <option selected>-- Select Channel --</option>
                        @if ($resource == 1)
                            <option value="email">Email(No-reply)</option>
                            <option value="wa">WA Broadcasting/Notification</option>
                            <option value="sm">SMS</option>
                            <option value="pl">Phone Line</option>
                        @elseif($resource == 2)
                            <option value="waba">WABA</option>
                            <option value="wc">Webchat</option>
                            {{-- <option value="em">Email</option> --}}
                            <option value="wa">WA Private No.</option>
                            {{-- <option value="ig">Instagram</option> --}}
                            @if ($bound == 'out')
                                <option value="plt">Phone Line Talkbot</option>
                                <option value="plh">Phone Line Human Agent</option>
                            @else
                                <option value="pl">Phone Line</option>
                            @endif
                        @endif
                    </select>
                    <x-jet-input-error for="channel" class="mt-2" />
                </div>


                @if (in_array($channel, ['wa', 'sm']))
                    {{-- Provider --}}
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="provider" value="{{ __('Provider') }}" />
                        <select name="provider" id="provider"
                            class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                            wire:model.debunce.800ms="provider">
                            <option value="1">Provider MK</option>
                            <option value="2">Provider EM</option>
                        </select>
                        <p class="text-gray-500 dark:text-slate-300 text-xs text-right m-2">Sending price is on
                            Provider
                        </p>
                        <x-jet-input-error for="provider" class="mt-2" />
                    </div>
                @endif

                <!-- is_enabled -->
                <div class="col-span-6 sm:col-span-6">

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="is_enabled" name="is_enabled" wire:model="is_enabled"
                                wire:model.defer="is_enabled" type="checkbox"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="is_enabled" class="font-medium text-gray-700 dark:text-slate-300">Sending OTP
                                (One Time Password) ?</label>
                            <p class="text-gray-500 dark:text-slate-300">Tick if you send OTP Message</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-4 p-3 bg-gray-100 border-1 rounded-lg space-y-3">
                <!-- Template Name -->
                <div class="col-span-6 sm:col-span-6">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="title"
                        wire:model.defer="title" wire:model.debunce.800ms="title" />
                    <x-jet-input-error for="title" class="mt-2" />
                </div>

                <!-- Template Description -->
                <div class="col-span-6 sm:col-span-6">
                    <x-jet-label for="text" value="{{ __('Message') }}" />

                    <x-textarea wire:model="text" wire:model.defer="text" value="text"
                        class="mt-1 block w-full"></x-textarea>
                    <x-jet-input-error for="text" class="mt-2" />
                </div>

                {{-- Provider --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="templateId" value="{{ __('Template') }}" />
                    <select name="templateId" id="templateId"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="templateId">
                        <option value=""></option>
                        <option value="1">Provider MK</option>
                        <option value="2">Provider EM</option>
                    </select>

                    <x-jet-input-error for="templateId" class="mt-2" />
                </div>
            </div>

        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    {{-- Sending Information --}}
    <x-jet-form-section submit="updateTemplate">
        <x-slot name="title">
            {{ __('Sending Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The sender and retriver information.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Template Name -->
            <div class="col-span-6 sm:col-span-6">
                <x-jet-label for="from" value="{{ __('From') }}" />
                <x-jet-input id="from" type="text" class="mt-1 block w-full" wire:model="from"
                    wire:model.defer="from" wire:model.debunce.800ms="from" :disabled="!Gate::check('update', $template)" />
                <x-jet-input-error for="from" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-6">
                <x-jet-label for="description" value="{{ __('To') }}" />

                <div class="mb-4">
                    <select wire:model="selectTo" id="selectTo"
                        class="form-select block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Please select the recipient</option>
                        <option value="manual" selected>Manual</option>
                        <option value="from_contact">From contact</option>
                        <option value="from_audience">From audience</option>
                    </select>
                </div>
                
                @if ($selectTo == 'manual')
                    <x-textarea wire:model="to" class="mt-1 block w-full"></x-textarea>
                    
                @endif
                @if ($selectTo == 'from_contact')

                    @if ($channel == 'email')
                        <div class="mb-4">
                            <label for="contact" class="block text-gray-700">Pilih Kontak:</label>
                            <select wire:model="selectedContact" id="contact"
                                class="form-multiselect block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Contact</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->email }}">{{ $contact->name }} -
                                        {{ $contact->email }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($channel == 'wa' || $channel == 'sm' || $channel == 'pl' || $channel == 'waba' || $channel == 'wc')
                        <div class="mb-4">
                            <label for="contact" class="block text-gray-700">Pilih Kontak:</label>
                            <select wire:model="selectedContact" id="contact"
                                class="form-multiselect block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Contact</option>
                                @foreach ($contacts as $contact)
                                    <option value="{{ $contact->phone }}">{{ $contact->name }} -
                                        {{ $contact->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                    silahkan pilih 1
                    @endif
                @endif

                @if ($selectTo == 'from_audience')

                    @if ($channel == 'email')
                        <div class="mb-4">
                            <label for="audience" class="block text-gray-700">Select Audience:</label>
                            <select wire:model="selectedAudience" id="audience"
                                class="form-multiselect block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Audience</option>
                                @foreach ($audience as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($to)
                            <div class="mt-4">
                                <label class="block text-gray-700">Audience Clients</label>
                                <div class="overflow-x-auto">
                                    <div class="border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:text-slate-300 mt-1 block w-full p-3"
                                        wire:model="to">
                                        {{ $to }}
                                    </div>
                                </div>
                            </div>
                        @endif


                    @elseif ($channel == 'wa' || $channel == 'sm' || $channel == 'pl' || $channel == 'waba' || $channel == 'wc')
                        <div class="mb-4">
                            <label for="audience" class="block text-gray-700">Select Audience:</label>
                            <select wire:model="selectedAudience" id="audience"
                                class="form-multiselect block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Audience</option>
                                @foreach ($audience as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($to)
                            <div class="mt-4">
                                <label class="block text-gray-700">Audience Clients</label>
                                <div class="overflow-x-auto">
                                    <div class="border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:text-slate-300 mt-1 block w-full p-3"
                                        wire:model="to">
                                        {{ $to }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                    silahkan pilih 2
                    @endif

                @endif
                
                <x-jet-input-error for="to" class="mt-2" />








        </x-slot>



        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Template saved.') }}
            </x-jet-action-message>

            <x-jet-button wire:click="sendResource">
                {{ __('Send') }}
            </x-jet-button>

        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

</div>
