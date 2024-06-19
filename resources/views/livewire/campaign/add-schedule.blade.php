<div>


    <x-jet-form-section submit="generateSchedule">
        <x-slot name="title">
            {{ __('Campaign Schedule') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Set the schedule for the campaign.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 bg-gray-50">
                                <span
                                    class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</span>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50">
                                <span
                                    class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</span>
                            </th>
                            <th scope="col" class="px-6 py-3 bg-gray-50">
                                <span
                                    class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($days as $day => $selected)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                                    <input id="days_{{ $day }}" wire:poll.4000ms="getCampaign"
                                        wire:model="days.{{ $day }}" type="checkbox"
                                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                        @if ($campaign->status == 'started') disabled @endif>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                    {{ ucfirst($day) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-jet-input id="times_{{ $day }}" type="time" class="block w-full"
                                        wire:model="times.{{ $day }}"
                                        disabled="{{ disableInput($campaign->status == 'pause' || $campaign->status == 'pending') }}" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Schedule generated successfully.') }}
            </x-jet-action-message>
            @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                <x-jet-button>
                    {{ __('Save Schedule') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>
</div>
