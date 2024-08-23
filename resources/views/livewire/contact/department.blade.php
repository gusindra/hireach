<div>
    <x-jet-form-section submit="saveDepartment({{ $client->id }})">
        <x-slot name="title">
            {{ __('Department') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update user client information department.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Department -->
            <div class="col-span-6 sm:col-span-3">
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="department" value="{{ __('Department') }}" />
                    <x-select id="sender" wire:model="department" :data="$listDepartment"
                        wire:model.defer="department" wire:model.debunce.800ms="department"></x-select>
                    <x-jet-input-error for="department" class="mt-2" />
                </div>
                <div class="mt-4">
                    @foreach ($activeDepartment as $d)
                        <span class="py-2 pl-2 bg-gray-300 rounded-sm border">{{$d->source_id}} - {{$d->name}}
                            <a wire:click="removeDepartment({{$d->id}})" class="cursor-pointer p-2 bg-red-100 hover:bg-red-300">x</a></span>
                    @endforeach
                </div>
            </div>

        </x-slot>
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="department_saved">
                {{ __('Department data updated.') }}
            </x-jet-action-message>

            <x-save-button show="{{ $client->status == 'draft' ? 'true' : 'false' }}">
                {{ __('Add') }}
            </x-save-button>
        </x-slot>
    </x-jet-form-section>
</div>
