<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resource') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-engagement', [])

        <div class="col-span-12 px-3 ml-24 mt-2">
            <div class="mx-auto">
                <div class="bg-white dark:bg-slate-600 overflow-hidden">
                    @if (auth()->user()->currentTeam->id != 1)
                        <div class="flex m-4">
                            @if (request()->get('resource') > 0)
                                @livewire('resource.add', ['way'=>request()->get('resource')])
                            @endif
                        </div>
                    @endif
                    <div class="m-4">
                        @if (request()->get('resource') == 1)
                            <livewire:table.sms-blast-table searchable="name, description"
                                resource="{{ request()->get('resource') }}" />
                        @elseif(request()->get('resource') == 2)
                            <livewire:table.requests-table searchable="name, description"
                                resource="{{ request()->get('resource') }}" />
                        @else
                            <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
                                <div class="mt-9 flex justify-center">
                                    <a href="{{ route('resources.index') }}?resource=1"
                                        class="flex gap-3 m-6 border text-base bg-yellow-600 rounded text-white border-gray-200 align-middle px-8 py-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                        </svg>
                                        One Way
                                    </a>
                                    <a href="{{ route('resources.index') }}?resource=2"
                                        class="flex gap-3 m-6 border text-base bg-yellow-600 rounded text-white border-gray-200 align-middle px-8 py-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                                        </svg>
                                        Two Way
                                    </a>
                                </div>
                                <div class="mt-9 flex justify-center">
                                    <img class="w-60" src="{{ url('/assets/img/select_2_1_way.svg') }}" />
                                </div>
                                <div class="text-center p-9">
                                    <p class="text-xl">Select Way Resource</p>
                                    <p class="mb-6">Start your campaign and enggangement your customer.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
