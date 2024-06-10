<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{__('Export Contact')}}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Export Contact') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-3 grid grid-cols-4 gap-2 p-2">
                    <a class="flex text-xs text-blue-800" href="{{ route('contact.export') }}">Export CSV <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hover:animate-bounce w-4 h-4">
                        <path d="M13.75 7h-3v5.296l1.943-2.048a.75.75 0 0 1 1.114 1.004l-3.25 3.5a.75.75 0 0 1-1.114 0l-3.25-3.5a.75.75 0 1 1 1.114-1.004l1.943 2.048V7h1.5V1.75a.75.75 0 0 0-1.5 0V7h-3A2.25 2.25 0 0 0 4 9.25v7.5A2.25 2.25 0 0 0 6.25 19h7.5A2.25 2.25 0 0 0 16 16.75v-7.5A2.25 2.25 0 0 0 13.75 7Z"></path>
                        </svg>
                    </a>
                @php $log = ''; @endphp
                @for ($i = 0; $i < 30; $i++)
                    @foreach ($group_date as $date)
                        @if($log!=$date->created_at->format('d-m-Y'))
                            <a class="flex text-xs text-blue-800" href="{{ route('contact.export') }}?mime=application&name={{$date->created_at->format('d-m-Y')}}&date={{$date->created_at->format('Y-m-d')}}">{{$date->created_at->format('d-m-Y')}} <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="hover:animate-bounce w-4 h-4">
                                <path d="M13.75 7h-3v5.296l1.943-2.048a.75.75 0 0 1 1.114 1.004l-3.25 3.5a.75.75 0 0 1-1.114 0l-3.25-3.5a.75.75 0 1 1 1.114-1.004l1.943 2.048V7h1.5V1.75a.75.75 0 0 0-1.5 0V7h-3A2.25 2.25 0 0 0 4 9.25v7.5A2.25 2.25 0 0 0 6.25 19h7.5A2.25 2.25 0 0 0 16 16.75v-7.5A2.25 2.25 0 0 0 13.75 7Z"></path>
                                </svg>
                            </a>
                            @php $log = $date->created_at->format('d-m-Y'); @endphp
                        @endif
                    @endforeach
                @endfor
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>

