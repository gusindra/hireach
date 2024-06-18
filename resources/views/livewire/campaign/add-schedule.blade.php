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
                                    <x-jet-checkbox id="days_{{ $day }}"
                                        wire:model="days.{{ $day }}" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ ucfirst($day) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-jet-input id="times_{{ $day }}" type="time" class="block w-full"
                                        wire:model="times.{{ $day }}" />
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

            <x-jet-button>
                {{ __('Save Schedule') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
