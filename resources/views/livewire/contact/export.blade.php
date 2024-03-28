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
            <div class="col-span-6 sm:col-span-3 grid grid-cols-3 gap-2 space-y-2 p-2">
                <div class="col-span-12 sm:col-span-2">
                    <a href="{{ route('contact.export') }}">Export CSV</a>
                </div>
                @php $log = ''; @endphp
                @foreach ($group_date as $date)
                    @if($log!=$date->created_at->format('d-m-Y'))
                        <a href="{{ route('contact.export') }}?date={{$date->created_at->format('Y-m-d')}}">{{$date->created_at->format('d-m-Y')}}</a>
                        @php $log = $date->created_at->format('d-m-Y'); @endphp
                    @endif
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>

