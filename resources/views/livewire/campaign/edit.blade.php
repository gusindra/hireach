<div>
    <div wire:poll.5000ms="checkSchedule" class="flex items-center justify-between bg-white p-4 rounded-lg shadow-md">
        <span
            class="ml-2 inline-flex items-center uppercase px-2 py-1 rounded text-md
        {{ $campaign->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : ($campaign->status === 'started' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
            {{ $campaign->status }}
        </span>
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="alert alert-danger">
                <span
                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    {{ session('error') }}
                </span>
            </div>
        @endif


        @if ($campaign->status == 'pending' || $campaign->status == 'pause')
            <x-jet-button wire:click="$set('showModal', true)">
                {{ __('Start Campaign') }}
            </x-jet-button>
        @elseif ($campaign->status == 'started')
            <button wire:click="pauseCampaign"
                class="bg-gray-800 text-white py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-300 hover:bg-gray-600 hover:text-gray-100">
                Pause Campaign
            </button>
        @endif
    </div>


    <x-jet-section-border />

    <x-jet-form-section submit="update ({{ $campaign_id }})">
        <x-slot name="title">
            {{ __('Campaign Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('The basic information of the campaign.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Campaign Title -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="title" value="{{ __('Title') }}" />

                <x-jet-input id="title"
                    disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}"
                    type="text" class="mt-1 block w-full" wire:model.defer="title" />

                <x-jet-input-error for="title" class="mt-2" />
            </div>



            <!-- Campaign Type -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="type" value="{{ __('Type') }}" />
                <x-jet-input id="type"
                    disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}"
                    type="text" class="mt-1 block w-full" wire:model.defer="type" />
                <x-jet-input-error for="type" class="mt-2" />
            </div>

            <!-- Campaign way_type -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="way_type" value="{{ __('Type Way') }}" />
                <x-jet-input id="way_type"
                    disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}"
                    type="text" class="mt-1 block w-full" wire:model.defer="way_type" />
                <x-jet-input-error for="way_type" class="mt-2" />
            </div>

            <!-- Campaign Budget -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="budget" value="{{ __('Budget') }}" />
                <x-jet-input id="budget"
                    disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}"
                    type="text" class="mt-1 block w-full" wire:model.defer="budget" />
                <x-jet-input-error for="budget" class="mt-2" />
            </div>

            <!-- is_otp -->
            <div class="col-span-6 sm:col-span-6">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_otp" name="is_otp" wire:model.defer="is_otp" type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            @if ($campaign->status == 'started') disabled @endif>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_otp" class="font-medium text-gray-700">OTP ?</label>
                        <p class="text-gray-500">Enable for turn on OTP feature.</p>
                    </div>
                </div>
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Campaign updated.') }}
            </x-jet-action-message>

            @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />
    <x-jet-form-section submit="update ({{ $campaign_id }},'provider')">
        <x-slot name="title">
            {{ __('Provider') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Select provider') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="provider" value="{{ __('Provider') }}" />
                <select id="provider"
                    class="block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    wire:model="provider" @if ($campaign->status == 'started') disabled @endif>
                    <option value="">{{ __('Select Provider') }}</option>
                    @foreach ($userProvider as $providerUser)
                        <option value="{{ $providerUser->provider->code }}">{{ $providerUser->provider->code }} |
                            {{ $providerUser->provider->name }}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="provider" class="mt-2" />
            </div>



            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="channel" value="{{ __('Channel') }}" />
                <x-jet-input id="channel"
                    disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}"
                    type="text" class="mt-1 block w-full" wire:model.defer="channel" />
                <x-jet-input-error for="channel" class="mt-2" />
            </div>
        </x-slot>


        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="savedProvider">
                {{ __('Provider updated.') }}
            </x-jet-action-message>

            @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="update ({{ $campaign_id }},'content')">
        <x-slot name="title">
            {{ __('Content') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Select content') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="template_id" value="{{ __('Template') }}" />
                <select name="template_id" id="template_id"
                    class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                    wire:model.debounce.800ms="template_id" @if ($campaign->status == 'started') disabled @endif>
                    <option selected value="0">No Template</option>
                    @foreach ($templates->groupBy('type') as $type => $group)
                        <optgroup label="{{ $type }}">
                            @foreach ($group as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                <x-jet-input-error for="template_id" class="mt-2" />
            </div>


            <div class="col-span-6 sm:col-span-6">
                @if (empty($template_id) || $template_id == '0')
                    <x-jet-label for="text" value="{{ __('Message') }}" />

                    <x-textarea wire:model="text"
                        disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}"
                        wire:model.defer="text" value="text" class="mt-1 block w-full"></x-textarea>
                    <x-jet-input-error for="text" class="mt-2" />
                @else
                    <x-jet-label for="text" value="{{ __('Message') }}" />
                    <div>{!! $text !!}</div>
                @endif
            </div>

        </x-slot>



        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="savedContent">
                {{ __('Content updated.') }}
            </x-jet-action-message>

            @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>

    <x-jet-section-border />

    <x-jet-form-section submit="update ({{ $campaign_id }},'fromTo')">
        <x-slot name="title">
            {{ __('Campaign Destination') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Select Campaign Destination for the campaign.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="from" value="{{ __('From') }}" />
                <x-jet-input id="from"
                    disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}"
                    type="text" class="mt-1 block w-full" wire:model.defer="from" />
                <x-jet-input-error for="from" class="mt-2" />
            </div>

            <!-- Campaign To -->
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="selectTo" value="{{ __('Select To') }}" />
                <select wire:model="selectTo" id="selectTo" @if ($campaign->status == 'started') disabled @endif
                    class="form-select mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="manual">Manual</option>
                    <option value="audience">Audience</option>
                </select>
            </div>

            @if ($selectTo === 'manual')
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="to" value="{{ __('To') }}" />
                    <textarea id="to" rows="4" @if ($campaign->status == 'started') disabled @endif
                        class="form-textarea mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        wire:model.defer="to"></textarea>
                    <x-jet-input-error for="to" class="mt-2" />
                </div>
            @elseif ($selectTo === 'audience')
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="audience_id" value="{{ __('Select Audience') }}" />
                    <select wire:model="audience_id" id="audience_id"
                        @if ($campaign->status == 'started') disabled @endif
                        class="form-select mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select Audience</option>
                        @foreach ($audience as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} |
                                ({{ $item->total_clients }} contacts)
                            </option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="audience_id" class="mt-2" />
                </div>
            @endif
            <div class="col-span-6 sm:col-span-4">
                <x-jet-input id="to"
                    class="form-textarea mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    wire:model.defer="to" readonly></x-jet-input>
            </div>


        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="savedFromTo">
                {{ __('Destination updated.') }}
            </x-jet-action-message>

            @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>


    <x-jet-section-border />


    @livewire('campaign.add-schedule', ['campaign_id' => $campaign_id])
    <x-jet-section-border />

    @if ($campaign->status === 'pending' || $campaign->status === 'pause')
        @livewire('campaign.delete', ['campaignId' => $campaign_id])
    @endif
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Start Campaign') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to start this campaign?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="startCampaign" wire:loading.attr="disabled">
                {{ __('Start Now') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
