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
                <div class="flex mb-4 space-x-3">
                    <div class="col-span-6 sm:col-span-4 w-1/2">
                        <x-jet-label for="typeShedule" value="{{ __('Type') }}" />
                            <select wire:model="typeShedule" id="typeShedule"  :disabled="{{$campaign->status == 'started'}}"
                                class="form-select block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="none">None</option>
                                    <option value="daily">Daily</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                            </select>
                        <x-jet-input-error for="typeShedule" class="mt-2" />
                    </div>
                    @if($typeShedule!='none')
                    <!-- typeLoop -->
                    <div class="col-span-6 sm:col-span-6 w-1/2">
                        <label class="block font-medium text-sm text-gray-700 dark:text-slate-300" for="from">
                            {{__(' .')}}
                        </label>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="typeLoop" name="typeLoop" wire:model.defer="typeLoop" type="checkbox" :disabled="{{$campaign->status == 'started'}}"
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                >
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="typeLoop" class="font-medium text-gray-700">Loop ?</label>
                                <p class="text-gray-500">Uncheck if one time campaign or Check to enable looping with shedule.</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-blue-100 border-blue-400 p-4 rounded-md text-slate-500 text-md">Tidak ada schedule, Campaign akan selesai jika semua kontak berhasil di kirimkan.</div>
                    @endif
                </div>
                @if($typeShedule!='none')
                <livewire:table.campaign-schedule-table hidden="delete" typeShedule="{{$typeShedule}}" canEdit="{{$campaign->status == 'pending' || $campaign->status == 'pause'}}" campaignId="{{ $campaign_id }}" />
                <table class="min-w-full divide-y divide-gray-200 hidden">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-50">
                                    <span
                                    class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</span>
                                </th>
                                @if($typeShedule!='daily')
                                <th scope="col" class="px-6 py-3 bg-gray-50">
                                    <span
                                    class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</span>
                                </th>
                                @endif
                                <th scope="col" class="px-6 py-3 bg-gray-50">
                                    <span
                                    class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</span>
                                </th>
                                <th scope="col" class="px-0 py-3 bg-gray-50 text-right">
                                    <span class="text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($schedule as $sch)
                                <tr>
                                    @if($typeShedule!='daily')
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                            Every <b>{{ !is_numeric($sch->day) ? '  '.ucfirst($sch->day) : ($sch->day<4 ? ($sch->day==1 ? $sch->day.'st':($sch->day==2 ? $sch->day.'nd':($sch->day==1 ? $sch->day.'rd':''))) : $sch->day.'th')}}</b>
                                            {{ $typeShedule == 'yearly' ? ' of '. date('F', mktime(0, 0, 0, $sch->month)) : ' of Month ' }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex justify-center">
                                            <div class="mx-4 my-auto text-xl">{{$sch->time}}</div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap text-right text-sm text-gray-500">
                                        @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                                            <a wire:click="deleteSchedule({{$sch->id}})" class="text-red-400 cursor-pointer">delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    <div class="flex">
                                        @if($typeShedule=='yearly')
                                        <select wire:model="month" id="month"
                                            class="form-select mr-4 block w-full rounded-none shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                        </select>
                                        @endif
                                        @if($typeShedule!='daily')
                                            <select wire:model="typeDay" id="typeDay"
                                                class="form-select block w-auto shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="name">Day Name</option>
                                                    <option value="day">Date</option>
                                            </select>

                                            @if($typeDay=='day')
                                                <input id="dateDay"
                                                    wire:model="dateDay" type="number" placeholder="{{$maxDateDay}}" min="1" max="{{$maxDateDay}}"
                                                    class="focus:ring-indigo-500 text-indigo-600 border-gray-300"  >
                                            @else
                                                <select wire:model="dateDay" id="dateDay"
                                                class="form-select block w-auto shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                    <option value="Sunday">Sunday</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                </select>
                                            @endif
                                        @endif
                                        <div class="flex">
                                            <input id="dateTime" type="time" class="focus:ring-indigo-500 text-indigo-600 border-gray-300"
                                                wire:model="dateTime" />
                                            <div class="mx-4 my-auto text-xl">{{$dateTime}} WIB (GMT +7)</div>
                                        </div>
                                    </div>
                                </td>
                                <td></td>
                                <td class="whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-row-reverse">
                                        @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                                            <x-jet-button wire:click="addSchedule">
                                                {{ __('Add Schedule') }}
                                            </x-jet-button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                @endif
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Schedule generated successfully.') }}
            </x-jet-action-message>
            <x-jet-action-message class="mr-3" on="deleted">
                {{ __('Successfully delete scheduled days.') }}
            </x-jet-action-message>
            <x-jet-action-message class="mr-3" on="fail_deleted">
                {{ __('Fail to delete scheduled days.') }}
            </x-jet-action-message>
            <x-jet-action-message class="mr-3" on="valid_day">
                {{ __('Correct date.') }}
            </x-jet-action-message>
            <x-jet-action-message class="mr-3" on="invalid_day">
                {{ __('Incorrect date.') }}
            </x-jet-action-message>
            @if ($campaign->status == 'pending' || $campaign->status == 'pause')
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            @endif
        </x-slot>
    </x-jet-form-section>

</div>
