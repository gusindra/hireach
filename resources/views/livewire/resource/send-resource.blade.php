<div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="bg-indigo-600 mb-4">
        <div class="w-full mx-auto p-3 px-3">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center">
                    <span class="flex p-2 rounded-lg bg-indigo-800">
                    <!-- Heroicon name: outline/speakerphone -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    </span>
                    <p class="ml-3 font-medium text-white truncate">
                    <span class="md:hidden">
                        Respond Question
                    </span>
                    <span class="hidden md:inline">
                        This template is use for respond question {{$resource}} Way.
                    </span>
                    </p>
                </div>
                <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                    <button type="button" class="-mr-1 flex p-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
                </button></div>
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
                <div class="col-span-2">
                    <x-jet-label class="capitalize" value="type" />

                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="border border-lightgrey-400 p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-sm ">
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
                                <div class="text-gray-700 dark:text-slate-300 text-sm capitalize">
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
                                <div class="text-gray-700 dark:text-slate-300 text-sm ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <x-jet-label for="name" value="{{ __('Updated At') }}" />
                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-sm ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($resource==2)
                <!-- Template Name -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="bound" value="{{ __('Bound') }}" />
                    <select
                        name="bound"
                        id="bound"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="bound"
                        >
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
                <select
                    name="channel"
                    id="channel"
                    class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debunce.800ms="channel"
                    >
                    <option selected>-- Select Channel --</option>
                    @if($resource==1)
                    <option value="1">Email(No-reply)</option>
                    <option value="2">WA Broadcasting/Notification</option>
                    <option value="2">SMS</option>
                    <option value="2">Phone Line</option>
                    @elseif($resource==2)
                        <option value="1">WABA</option>
                        <option value="2">Webchat</option>
                        <option value="2">Email</option>
                        <option value="2">WA Private No.</option>
                        <option value="2">Instagram</option>
                        @if($bound=='out')
                        <option value="2">Phone Line Talkbot</option>
                        <option value="2">Phone Line Human Agent</option>
                        @else
                        <option value="2">Phone Line</option>
                        @endif
                    @endif
                </select>
                <x-jet-input-error for="channel" class="mt-2" />
            </div>

            <!-- is_enabled -->
            <div class="col-span-6 sm:col-span-6">

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_enabled" name="is_enabled" wire:model="is_enabled"
                            wire:model.defer="is_enabled" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_enabled" class="font-medium text-gray-700 dark:text-slate-300">is enable ?</label>
                        <p class="text-gray-500 dark:text-slate-300">Enable template to send respond to your customer.</p>
                    </div>
                </div>
            </div>

            <!-- is_wait_for_chat -->
            <div class="col-span-6 sm:col-span-6">

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_waiting" name="is_waiting" wire:model="is_waiting"
                            wire:model.defer="is_waiting" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_waiting" class="font-medium text-gray-700 dark:text-slate-300">is waiting Agent Response ?</label>
                        <p class="text-gray-500 dark:text-slate-300">Enable to notif agent to give response to the customer.</p>
                    </div>
                </div>
            </div>

        </x-slot>

        @if (Gate::check('update', $template))
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Template saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        @endif
    </x-jet-form-section>

    <x-jet-section-border />

    {{-- Template Information --}}
    <x-jet-form-section submit="updateTemplate">
        <x-slot name="title">
            {{ __('Template') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The template\'s name and information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 grid grid-cols-5">
                <!-- Type Information -->
                <div class="col-span-2">
                    <x-jet-label class="capitalize" value="type" />

                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="border border-lightgrey-400 p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-sm ">
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
                                <div class="text-gray-700 dark:text-slate-300 text-sm capitalize">
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
                                <div class="text-gray-700 dark:text-slate-300 text-sm ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <x-jet-label for="name" value="{{ __('Updated At') }}" />
                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-sm ">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Name -->
            <div class="col-span-6 sm:col-span-6">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name"
                            type="text"
                            class="mt-1 block w-full"
                            wire:model="name"
                            wire:model.defer="name"
                            wire:model.debunce.800ms="name"
                            :disabled="! Gate::check('update', $template)" />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <!-- Template Description -->
            <div class="col-span-6 sm:col-span-6">
                <x-jet-label for="description" value="{{ __('Description') }}" />

                <x-textarea wire:model="description"
                            wire:model.defer="description"
                            value="description" class="mt-1 block w-full" :disabled="! Gate::check('update', $template)"></x-textarea>
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <!-- is_enabled -->
            <div class="col-span-6 sm:col-span-6">

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_enabled" name="is_enabled" wire:model="is_enabled"
                            wire:model.defer="is_enabled" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_enabled" class="font-medium text-gray-700 dark:text-slate-300">is enable ?</label>
                        <p class="text-gray-500 dark:text-slate-300">Enable template to send respond to your customer.</p>
                    </div>
                </div>
            </div>

            <!-- is_wait_for_chat -->
            <div class="col-span-6 sm:col-span-6">

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_waiting" name="is_waiting" wire:model="is_waiting"
                            wire:model.defer="is_waiting" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_waiting" class="font-medium text-gray-700 dark:text-slate-300">is waiting Agent Response ?</label>
                        <p class="text-gray-500 dark:text-slate-300">Enable to notif agent to give response to the customer.</p>
                    </div>
                </div>
            </div>

        </x-slot>

        @if (Gate::check('update', $template))
            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Template saved.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        @endif
    </x-jet-form-section>

</div>
