<div>

    @if ($status->status == 'draft')
        <div class=" text-center p-4 rounded-md shadow-md">
            <x-jet-action-message class="mr-3" on="update_status">
                {{ __('Your order submitted') }}
            </x-jet-action-message>
            <x-jet-button class="ml-2" type="submit" wire:click="update">
                {{ __('Submit Order') }}
            </x-jet-button>

            @if ($errorMessage)
                <div class="text-red-500 p-2">
                    {!! $errorMessage !!}
                </div>
            @endif
        </div>
    @endif
</div>
