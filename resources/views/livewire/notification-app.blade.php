<div wire:poll.visible>
    <div class="absolute right-0 w-10">
        <x-jet-dropdown align="right" width="60">
            <x-slot name="trigger">
                <span class="inline-flex rounded-md mt-4">
                    <button type="button" class="inline-flex hover:bg-gray-50 items-center px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 supports-backdrop-blur:bg-white/60 dark:bg-slate-800 dark:hover:bg-slate-600 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                        @if($data['count']>0)
                            <span id="icon-notif" style="font-size: xx-small" class="absolute animate-pulse mt-3 mr-1 top-0 right-1 p-1 font-bold leading-none text-white transform bg-red-600 rounded-full">{{$data['count']}}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 dark:text-slate-300 dark:hover:text-slate-500 text-slate-600 hover:text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 dark:text-slate-300 dark:hover:text-slate-500 text-slate-600 hover:text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
                            </svg>
                        @endif
                    </button>
                </span>
            </x-slot>

            <x-slot name="content">
                <div class="w-60 overflow-y-auto h-auto max-h-96">
                    <!-- Notification -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Notification') }}
                    </div>

                    @foreach ($data['waiting'] as $wait)
                        <a class="block px-4 py-2 text-sm font-bold leading-5 bg-pink-400 text-white hover:bg-pink-300 focus:outline-none focus:bg-pink-600 transition"
                            href="{{ route('message') }}?id={{ Hashids::encode($wait->id) }}">
                            <div class="flex items-center">
                                <div class="truncate1">
                                    <span class="uppercase">Waiting</span> <br>
                                    <span class="capitalize text-xs"
                                        style="word-wrap: break-word;white-space: pre-wrap;word-break: break-all;">{{ $wait->name }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if ($data['notif']->count() > 0)
                        @foreach ($data['notif'] as $item)
                            <a class="block px-4 py-2 text-sm leading-5 text-gray-700 dark:bg-blue-600 dark:text-slate-800 {{ $item->status == 'unread' ? 'bg-green-200' : '' }} {{ $item->status == 'new' ? 'bg-gray-200' : '' }} hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition"
                                href="{{ $item->type == 'admin' ? '#' : route('notification.read', [$item->id]) }}"
                                {{ $item->type == 'admin' ? 'wire:click=actionShowModal(' . $item->id . ')' : '' }}>
                                <div class="flex items-center">
                                    <div class="truncate1">
                                        <span class="uppercase text-xs font-bold">{{ $item->type }}
                                            {{ $item->ticket && $item->ticket->request && $item->ticket->request->client ? $item->ticket->request->client->name : '' }}</span>
                                        <br>
                                        <span class="capitalize text-xs"
                                            style="word-wrap: break-word;white-space: pre-wrap;word-break: break-all; ">{{ $item->notification }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach

                        <div class="block px-4 py-2 text-xs text-gray-600 text-center">
                            <a href="{{ route('notification') }}">{{ __('View more') }}</a>
                        </div>
                    @else
                        <div class="block px-4 py-2 text-xs text-gray-600 text-center">
                            <a href="{{ route('notification') }}">{{ __('View more') }}</a>
                        </div>
                    @endif
                </div>
            </x-slot>
        </x-jet-dropdown>
    </div>
    <!-- Attachment Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Announcement') }}
        </x-slot>

        <x-slot name="content">
            {{ $currentMessage }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    @if ($data['count'] > 0 && $data['status']=='Online')
        <style>
            .apply-shake {
                animation: shake 1s;
                animation-iteration-count: infinite;
            }

            @keyframes shake {
                0% {
                    transform: translate(1px, 1px) rotate(0deg);
                }

                10% {
                    transform: translate(-1px, -2px) rotate(-1deg);
                }

                20% {
                    transform: translate(-3px, 0px) rotate(1deg);
                }

                30% {
                    transform: translate(3px, 2px) rotate(0deg);
                }

                40% {
                    transform: translate(1px, -1px) rotate(1deg);
                }

                50% {
                    transform: translate(-1px, 2px) rotate(-1deg);
                }

                60% {
                    transform: translate(-3px, 1px) rotate(0deg);
                }

                70% {
                    transform: translate(3px, 1px) rotate(-1deg);
                }

                80% {
                    transform: translate(-1px, -1px) rotate(1deg);
                }

                90% {
                    transform: translate(1px, 2px) rotate(0deg);
                }

                100% {
                    transform: translate(1px, -2px) rotate(-1deg);
                }
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                window.addEventListener('event-notification', event => {
                    var d = document.getElementById("icon-notif");
                    document.getElementById('sound').play();
                    setTimeout((e) => {
                        var d = document.getElementById("icon-notif");
                        d.classList.add("apply-shake");
                    }, 10000);
                    d.classList.remove("apply-shake");
                });
            });
        </script>
    @endif
</div>
