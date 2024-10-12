<div>
    <div class="flex items-center text-right p-3">
        <x-add-button wire:click="actionShowModal">
            {{ __('Add Contact to Department') }}
        </x-add-button>
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
                    list="department" wire:model.debunce.800ms="search" autofocus placeholder="Department Name Keyword" />
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
                <x-jet-input autocomplete="off" id="contact" type="text" class="mt-1 block w-full" placeholder="Existing Contact Keyword"
                    list="client" wire:model.debunce.800ms="contact" autofocus />
                <!-- <datalist id="client">
                    @foreach($data as $key => $da)
                        <option value="{{$da->id}}">{{$da->name}}</option>
                    @endforeach
                </datalist> -->
                <table class="my-2"> 
                    @if(count($data)>0)
                        @foreach($data as $da)
                        <tr>
                            <td class="flex gap-2"><input wire:model.debunce.800ms="selectContact" id="contact-{{$da->id}}" type="radio" name="contact" value="{{$da->id}}" /><label for="contact-{{$da->id}}"><b>{{$da->name}}</b> ({{$da->phone}} - {{$da->email}})</label></td>
                            <td><img class="h-8" src="{{$da->profile_photo_url}}" /></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="flex gap-2"><input wire:model.debunce.800ms="new" id="contact-new" type="checkbox" name="contact" value="0" /><label for="contact-0">New Contact</label></td>
                            <td></td>
                        </tr>
                    @endif
                </table>

                @if ($new)
                <div class="flex">
                    <div class="col-span-6 sm:col-span-4 p-2">
                        <div class="col-span-12 sm:col-span-2">
                            <x-jet-label for="input.name" value="{{ __('Name') }}" />
                            <x-jet-input id="client_name" type="text" class="mt-1 block w-full" wire:model="input.name"
                                wire:model.defer="input.name" wire:model.debunce.800ms="input.name" />
                            <x-jet-input-error for="input.name" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-4 p-2">
                        <x-jet-label for="input.email" value="{{ __('Email') }}" />
                        <x-jet-input autocomplete="off" id="input.email" type="text" class="mt-1 block w-full"
                            wire:model.debunce.800ms="input.email" autofocus />
                        <x-jet-input-error for="input.email" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4 p-2">
                        <x-jet-label for="input.phone" value="{{ __('Phone') }}" />
                        <x-jet-input autocomplete="off" id="input.phone" type="text" class="mt-1 block w-full"
                            wire:model.debunce.800ms="input.phone" autofocus />
                        <x-jet-input-error for="input.phone" class="mt-2" />
                    </div>
                </div>
                @endif
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
