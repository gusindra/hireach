<div>
    @if ($modal)
        <div class="col-span-6 grid grid-cols-6 gap-2">
            <div class="col-span-2 lg:col-span-2 p-3 bg-gray-100 border-1 rounded-lg space-y-2">
                <!-- Channel -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="channel" value="{{ __('Channel') }}" />
                    <select name="channel" id="channel"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="channel">
                        <option selected>-- Select Channel --</option>
                        @if ($resource == 1)
                            @if (!empty($providers))
                                @foreach ($providers as $provider)
                                    <option value="{{ strtolower($provider->channel) }}">{{ $provider->channel }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">No providers found</option>
                            @endif
                        @elseif($resource == 2)
                            @if ($providers->isNotEmpty())
                                @foreach ($providers as $provider)
                                    <option value="{{ strtolower($provider->channel) }}">{{ $provider->channel }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">No providers found</option>
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
                            <label for="is_enabled" class="font-medium text-gray-700 dark:text-slate-300">Sending
                                OTP
                                (One Time Password) ?</label>
                            <p class="text-gray-500 dark:text-slate-300">Tick if you send OTP Message</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-4 lg:col-span-4 p-3 bg-gray-100 border-1 rounded-lg space-y-3">
                <!-- Template Name -->
                <div class="col-span-6 sm:col-span-6">
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="title"
                        wire:model.defer="title" wire:model.debunce.800ms="title" />
                    <x-jet-input-error for="title" class="mt-2" />
                </div>

                <!-- Template Description -->
                {{-- Template --}}
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="templateId" value="{{ __('Template') }}" />
                    <select name="templateId" id="templateId"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="templateId">
                        <option value="0">No Template</option>
                        @foreach ($templates->groupBy('type') as $type => $group)
                            <optgroup label="{{ $type }}">
                                @foreach ($group as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>

                    <x-jet-input-error for="templateId" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6">
                    @if ($templateId == '0')
                        <x-jet-label for="text" value="{{ __('Message') }}" />

                        <x-textarea wire:model="text" wire:model.defer="text" value="text"
                            class="mt-1 block w-full"></x-textarea>
                        <x-jet-input-error for="text" class="mt-2" />
                    @else
                        <x-jet-label for="text" value="{{ __('Message') }}" />
                        <div>{!! $text !!}</div>
                    @endif
                </div>
            </div>

            <div class="col-span-6 lg:col-span-6 space-y-2">
                <div class="col-span-6 lg:col-span-6 p-3 bg-gray-100 border-1 rounded-lg space-y-2">
                    <x-jet-label for="from" value="{{ __('From') }}" />
                    {{-- <x-jet-input id="from" type="text" class="mt-1 block w-full" wire:model="from"
                        wire:model.defer="from" wire:model.debunce.800ms="from" :disabled="!Gate::check('update', $template)" /> --}}
                    <div class="mb-4">
                        <select wire:model="from" id="from"
                            class="form-select block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach ($fromList as $froml)
                                <option value="{{ $froml }}">{{ $froml }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-jet-input-error for="from" class="mt-2" />
                </div>

                <div class="ol-span-6 lg:col-span-6 p-3 bg-gray-100 border-1 rounded-lg space-x-0 grid grid-cols-2">
                    <div>
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
                    </div>

                    @if ($selectTo == 'manual')
                        <x-textarea wire:model="to" class="mt-1 block w-full col-span-2"></x-textarea>
                    @endif

                    @if ($selectTo == 'from_contact')
                        @if ($channel == 'email' || $channel != 'email')
                            <div class="mb-1">
                                <label for="contact"
                                    class="block font-medium text-sm text-gray-700 dark:text-slate-300">Select
                                    Contact:</label>
                                <div x-data="{ open: false }" class="relative">
                                    <input type="text" id="search"
                                        class="form-input block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        wire:model.debounce.300ms="search" @focus="open = true" @input="open = true"
                                        @click="open = true" @click.away="open = false"
                                        placeholder="{{ $search == '' ? 'No Contact Add' : '' }}">
                                    <x-jet-action-message class="mr-3" on="loading">
                                        <svg class="animate-spin mr-3 h-5 w-5 text-gray-300 absolute right-0 -mt-8"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </x-jet-action-message>
                                    <input type="hidden" id="selectedContact" name="selectedContact"
                                        wire:model="{{ $channel == 'email' ? 'selectedEmail' : 'selectedPhone' }}">
                                    <div x-show="open"
                                        class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg">
                                        <ul
                                            class="overflow-auto h-40 {{ $selectedContact == '' ? 'block' : 'hidden' }}">
                                            @forelse ($contactArray as $contact)
                                                <li wire:key="{{ $loop->index }}"
                                                    wire:click="{{ $channel == 'email' ? "selectContact('$contact->email')" : "selectContact('$contact->phone')" }}"
                                                    class="cursor-pointer px-4 py-2 hover:bg-indigo-200">
                                                    {{ $contact->name != '' ? $contact->name . ' - ' : '' }}
                                                    {{ $channel == 'email' ? $contact->email : $contact->phone }}
                                                </li>
                                            @empty
                                                <li class="px-4 py-2">No results found</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-red-600 text-sm">Please select Channel first to choose contact!</p>
                        @endif
                    @endif



                    @if ($selectTo == 'from_audience')
                        @if ($channel == 'email')
                            <div class="mb-4">
                                <label for="audience"
                                    class="block font-medium text-sm text-gray-700 dark:text-slate-300">Select
                                    Audience:</label>
                                <div x-data="{ open: false }" class="relative mt-3">
                                    <input type="text" id="search" placeholder="Select Audience"
                                        class="form-input block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        wire:model.debounce.300ms="search" @focus="open = true" @input="open = true"
                                        @click.away="open = false">

                                    <input type="hidden" id="selectedAudience" name="selectedAudience"
                                        wire:model="selectedAudience">

                                    <div x-show="open"
                                        class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg max-h-40 overflow-y-auto">
                                        <ul>
                                            @forelse ($audiences as $audience)
                                                <li wire:key="{{ $audience->id }}"
                                                    @mousedown.prevent="$wire.selectAudience({{ $audience->id }}); open = false;"
                                                    class="cursor-pointer px-4 py-2 hover:bg-indigo-200">
                                                    {{ $audience->name }}
                                                </li>
                                            @empty
                                                <li class="px-4 py-2">No results found</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            @if ($to)
                                <div class="col-span-2">
                                    <label class="block font-medium text-sm text-gray-700 dark:text-slate-300">Audience
                                        Clients</label>
                                    <div class="overflow-x-auto">
                                        <div class="border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:text-slate-300 mt-1 block w-full p-3"
                                            wire:model="to">
                                            {{ $to }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif ($channel != 'email')
                            <div>
                                <div class="mb-4">
                                    <label for="audience"
                                        class="block font-medium text-sm text-gray-700 dark:text-slate-300">Select
                                        Audience:</label>
                                    <div x-data="{ open: false }" class="relative mt-3">
                                        <input type="text" id="search" placeholder="Select Audience"
                                            class="form-input block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            wire:model.debounce.300ms="search" @focus="open = true"
                                            @input="open = true" @click.away="open = false">

                                        <input type="hidden" id="selectedAudience" name="selectedAudience"
                                            wire:model="selectedAudience">

                                        <div x-show="open"
                                            class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg max-h-40 overflow-y-auto">
                                            <ul>
                                                @forelse ($audiences as $audience)
                                                    <li wire:key="{{ $audience->id }}"
                                                        @mousedown.prevent="$wire.selectAudience({{ $audience->id }}); open = false;"
                                                        class="cursor-pointer px-4 py-2 hover:bg-indigo-200">
                                                        {{ $audience->name }}
                                                    </li>
                                                @empty
                                                    <li class="px-4 py-2">No results found</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($to)
                                <div class="col-span-2">
                                    <label class="block font-medium text-sm text-gray-700 dark:text-slate-300">Audience
                                        Clients</label>
                                    <div class="overflow-x-auto">
                                        <div class="border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:text-slate-300 mt-1 block w-full p-3"
                                            wire:model="to">
                                            {{ $to }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <p class="text-red-600 text-sm">Please select Channel first to choose Audience!</p>
                        @endif
                    @endif

                </div>
                <x-jet-input-error for="to" class="mt-2 mb-2" />
            </div>

            <div class="col-end-7 col-span-1">
                <x-jet-action-message class="mr-3" on="resource_saved">
                    {{ __('Resource data saved.') }}
                </x-jet-action-message>
                <button type="button"
                    class="w-full flex justify-center items-center my-auto p-3 text-xs text-white bg-indigo-800 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white"
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
    @else
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class=" hidden bg-indigo-600 mb-4">
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
                                This template is use for respond question <span class="font-bold">{{ $resource }}
                                    Way</span>.
                            </span>
                        </p>
                    </div>
                    <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                        <x-jet-action-message class="mr-3" on="resource_saved">
                            {{ __('Resource data saved.') }}
                        </x-jet-action-message>
                        <button type="button" onclick="closeModal()"
                            class="flex items-center my-auto p-3 text-xs text-white bg-indigo-800 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white"
                            wire:click="sendResource">
                            SEND
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="ml-2 w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Send Notification Information --}}
        <x-jet-form-section submit="updateTemplate">
            <x-slot name="title">
                {{ __('Sending Resource') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Resource information.') }}<br><br>
                <span class="hidden md:inline">
                    This request is use for send request notification using selected channel.
                </span><br><br>
                <div class="col-span-1">
                    <x-jet-label class="capitalize text-xs" value="type" />
                    <div class="flex items-center mt-1">
                        <div class="p-3 pl-0 pt-0">
                            <div class="p-1 rounded-lg">
                                <div class="text-gray-700 dark:text-slate-300 text-base">
                                    <span class="font-bold">{{ $resource }} Way</span>
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
                <div>
                    <x-jet-action-message class="mr-3" on="resource_saved">
                        {{ __('Resource data saved.') }}
                    </x-jet-action-message>
                    <button type="button"
                        class="w-full flex justify-center items-center my-auto p-3 text-xs text-white bg-indigo-800 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white"
                        wire:click="sendResource">
                        SEND
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="ml-2 w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                    </button>
                </div>
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 grid grid-cols-6 gap-2">
                    <div class="col-span-2 lg:col-span-2 p-3 bg-gray-100 border-1 rounded-lg space-y-2">
                        @if ($resource == 2)
                            <!-- Template Name -->
                            {{-- <div class="col-span-6 sm:col-span-4">
                                <x-jet-label for="bound" value="{{ __('Bound') }}" />
                                <select name="bound" id="bound"
                                    class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                    wire:model.debunce.800ms="bound">
                                    <option >-- Select bound --</option>
                                    <option selected value="out">Out</option>
                                    <option value="in">In</option>
                                </select>
                                <x-jet-input-error for="bound" class="mt-2" />
                            </div> --}}
                        @endif
                        <!-- Template Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="channel" value="{{ __('Channel') }}" />
                            <select name="channel" id="channel"
                                class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                wire:model.debunce.800ms="channel">
                                <option selected>-- Select Channel --</option>
                                @if ($resource == 1)
                                    @if ($providers->isNotEmpty())
                                        @foreach ($providers as $provider)
                                            <option value="{{ strtolower($provider->channel) }}">
                                                {{ $provider->channel }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No providers found</option>
                                    @endif
                                @elseif($resource == 2)
                                    @if ($providers->isNotEmpty())
                                        @foreach ($providers as $provider)
                                            <option value="{{ strtolower($provider->channel) }}">
                                                {{ $provider->channel }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="">No providers found</option>
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
                                    <label for="is_enabled"
                                        class="font-medium text-gray-700 dark:text-slate-300">Sending
                                        OTP
                                        (One Time Password) ?</label>
                                    <p class="text-gray-500 dark:text-slate-300">Tick if you send OTP Message</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-4 lg:col-span-4 p-3 bg-gray-100 border-1 rounded-lg space-y-3">
                        <!-- Template Name -->
                        <div class="col-span-6 sm:col-span-6">
                            <x-jet-label for="title" value="{{ __('Title') }}" />
                            <x-jet-input id="title" type="text" class="mt-1 block w-full" wire:model="title"
                                wire:model.defer="title" wire:model.debunce.800ms="title" />
                            <x-jet-input-error for="title" class="mt-2" />
                        </div>

                        <!-- Template Description -->
                        {{-- Template --}}
                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="templateId" value="{{ __('Template') }}" />
                            <select name="templateId" id="templateId"
                                class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                                wire:model.debunce.800ms="templateId">
                                <option value="0">No Template</option>
                                @foreach ($templates->groupBy('type') as $type => $group)
                                    <optgroup label="{{ $type }}">
                                        @foreach ($group as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>

                            <x-jet-input-error for="templateId" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            @if ($templateId == '0')
                                <x-jet-label for="text" value="{{ __('Message') }}" />

                                <x-textarea wire:model="text" wire:model.defer="text" value="text"
                                    class="mt-1 block w-full"></x-textarea>
                                <x-jet-input-error for="text" class="mt-2" />
                            @else
                                <x-jet-label for="text" value="{{ __('Message') }}" />
                                <div>{!! $text !!}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-span-6 lg:col-span-6 space-y-2">
                        <div class="col-span-6 lg:col-span-6 p-3 bg-gray-100 border-1 rounded-lg space-y-2">
                            <x-jet-label for="from" value="{{ __('From') }}" />
                            {{-- <x-jet-input id="from" type="text" class="mt-1 block w-full" wire:model="from"
                                wire:model.defer="from" wire:model.debunce.800ms="from" :disabled="!Gate::check('update', $template)" /> --}}
                            <div class="mb-4">
                                <select wire:model="from" id="from"
                                    class="form-select block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach ($fromList as $froml)
                                        <option value="{{ $froml }}">{{ $froml }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-jet-input-error for="from" class="mt-2" />
                        </div>

                        <div class="ol-span-6 lg:col-span-6 p-3 bg-gray-100 border-1 rounded-lg space-y-2">
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
                                @if ($channel == 'email' || $channel != 'email')
                                    <div class="mb-1">
                                        <label for="contact"
                                            class="block font-medium text-sm text-gray-700 dark:text-slate-300">Select
                                            Contact:</label>
                                        <div x-data="{ open: false }" class="relative">
                                            <input type="text" id="search"
                                                class="form-input block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                wire:model.debounce.300ms="search" @focus="open = true"
                                                @input="open = true" @click="open = true" @click.away="open = false"
                                                placeholder="{{ $search == '' ? 'No Contact Add' : '' }}">
                                            <x-jet-action-message class="mr-3" on="loading">
                                                <svg class="animate-spin mr-3 h-5 w-5 text-gray-300 absolute right-0 -mt-8"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </x-jet-action-message>
                                            <input type="hidden" id="selectedContact" name="selectedContact"
                                                wire:model="{{ $channel == 'email' ? 'selectedEmail' : 'selectedPhone' }}">
                                            <div x-show="open"
                                                class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg">
                                                <ul
                                                    class="overflow-auto h-40 {{ $selectedContact == '' ? 'block' : 'hidden' }}">
                                                    @forelse ($contactArray as $contact)
                                                        <li wire:key="{{ $loop->index }}"
                                                            wire:click="{{ $channel == 'email' ? "selectContact('$contact->email')" : "selectContact('$contact->phone')" }}"
                                                            class="cursor-pointer px-4 py-2 hover:bg-indigo-200">
                                                            {{ $contact->name != '' ? $contact->name . ' - ' : '' }}
                                                            {{ $channel == 'email' ? $contact->email : $contact->phone }}
                                                        </li>
                                                    @empty
                                                        <li class="px-4 py-2">No results found</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-red-600 text-sm">Please select Channel first to choose contact!</p>
                                @endif
                            @endif



                            @if ($selectTo == 'from_audience')
                                @if ($channel == 'email')
                                    <div class="mb-4">
                                        <label for="audience"
                                            class="block font-medium text-sm text-gray-700 dark:text-slate-300">Select
                                            Audience:</label>
                                        <div x-data="{ open: false }" class="relative mt-3">
                                            <input type="text" id="search" placeholder="Select Audience"
                                                class="form-input block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                wire:model.debounce.300ms="search" @focus="open = true"
                                                @input="open = true" @click.away="open = false">

                                            <input type="hidden" id="selectedAudience" name="selectedAudience"
                                                wire:model="selectedAudience">

                                            <div x-show="open"
                                                class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg max-h-40 overflow-y-auto">
                                                <ul>
                                                    @forelse ($audiences as $audience)
                                                        <li wire:key="{{ $audience->id }}"
                                                            @mousedown.prevent="$wire.selectAudience({{ $audience->id }}); open = false;"
                                                            class="cursor-pointer px-4 py-2 hover:bg-indigo-200">
                                                            {{ $audience->name }}
                                                        </li>
                                                    @empty
                                                        <li class="px-4 py-2">No results found</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($to)
                                        <div class="col-span-2">
                                            <label
                                                class="block font-medium text-sm text-gray-700 dark:text-slate-300">Audience
                                                Clients</label>
                                            <div class="overflow-x-auto">
                                                <div class="border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:text-slate-300 mt-1 block w-full p-3"
                                                    wire:model="to">
                                                    {{ $to }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @elseif ($channel != 'email')
                                    <div>
                                        <div class="mb-4">
                                            <label for="audience"
                                                class="block font-medium text-sm text-gray-700 dark:text-slate-300">Select
                                                Audience:</label>
                                            <div x-data="{ open: false }" class="relative mt-3">
                                                <input type="text" id="search" placeholder="Select Audience"
                                                    class="form-input block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    wire:model.debounce.300ms="search" @focus="open = true"
                                                    @input="open = true" @click.away="open = false">

                                                <input type="hidden" id="selectedAudience" name="selectedAudience"
                                                    wire:model="selectedAudience">

                                                <div x-show="open"
                                                    class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg max-h-40 overflow-y-auto">
                                                    <ul>
                                                        @forelse ($audiences as $audience)
                                                            <li wire:key="{{ $audience->id }}"
                                                                @mousedown.prevent="$wire.selectAudience({{ $audience->id }}); open = false;"
                                                                class="cursor-pointer px-4 py-2 hover:bg-indigo-200">
                                                                {{ $audience->name }}
                                                            </li>
                                                        @empty
                                                            <li class="px-4 py-2">No results found</li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($to)
                                        <div class="col-span-2">
                                            <label
                                                class="block font-medium text-sm text-gray-700 dark:text-slate-300">Audience
                                                Clients</label>
                                            <div class="overflow-x-auto">
                                                <div class="border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm dark:bg-slate-800 dark:text-slate-300 mt-1 block w-full p-3"
                                                    wire:model="to">
                                                    {{ $to }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-red-600 text-sm">Please select Channel first to choose Audience!</p>
                                @endif
                            @endif
                        </div>
                        <x-jet-input-error for="to" class="mt-2 mb-2" />
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
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="resource_saved">
                    {{ __('Resource data saved.') }}
                </x-jet-action-message>

                <x-jet-button wire:click="sendResource">
                    {{ __('Send') }}
                </x-jet-button>

            </x-slot>
        </x-jet-form-section>

        <x-jet-section-border />
    @endif
</div>
