<div>
    @props(['status','selection', 'component' => 'jet-dropdown-link'])
    <form>
        @method('PUT')
        @csrf
        @foreach ($selection as $select)
            <x-dynamic-component :component="$component" href="#" wire:click="updateStatus('{{$select}}')">
                <div class="flex items-center justify-between">
                    <div class="truncate">{{$select}}</div>
                </div>
            </x-dynamic-component>
        @endforeach
    </form>
</div>
