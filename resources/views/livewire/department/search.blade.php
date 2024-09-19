<div>
    <div class="flex items-center text-right">
        <x-jet-button wire:click="actionShowModal">
            {{ __('Setting Contact') }}
        </x-jet-button>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Setting Contact') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="search" value="{{ __('Department') }}" />
                <x-jet-input autocomplete="off" id="search" type="text" class="mt-1 block w-full"
                    list="department" wire:model.debunce.800ms="search" autofocus />
                <!-- <datalist id="department">
                    @foreach($depts as $key => $dp)
                        <option value="{{$dp->id}}">{{$dp->name}}</option>
                    @endforeach
                </datalist> -->
                <table class="my-2">
                    @foreach($depts as $dp)
                    <tr>
                        <td colspan="2" class="flex gap-8"><input wire:model.debunce.800ms="selectDepartment" id="dept-{{$dp->id}}" type="radio" name="department" value="{{$dp->id}}" /><label for="dept-{{$dp->id}}"><b>{{$dp->name}}</b> ({{$dp->source_id}} - {{$dp->server}})</label></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="col-span-6 sm:col-span-4 p-2">
                <x-jet-label for="contact" value="{{ __('Contact') }}" />
                <x-jet-input autocomplete="off" id="contact" type="text" class="mt-1 block w-full"
                    list="client" wire:model.debunce.800ms="contact" autofocus />
                <!-- <datalist id="client">
                    @foreach($data as $key => $da)
                        <option value="{{$da->id}}">{{$da->name}}</option>
                    @endforeach
                </datalist> -->
                <table class="my-2">
                    @foreach($data as $da)
                    <tr>
                        <td class="flex gap-8"><input wire:model.debunce.800ms="selectContact" id="contact-{{$da->id}}" type="radio" name="contact" value="{{$da->id}}" /><label for="contact-{{$da->id}}"><b>{{$da->name}}</b> ({{$da->phone}} - {{$da->email}})</label></td>
                        <td><img class="h-8" src="{{$da->profile_photo_url}}" /></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="update()" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
