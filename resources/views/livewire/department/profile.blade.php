<div>
    <x-jet-form-section submit="update">
        <x-slot name="title">
            Edit Department
        </x-slot>

        <x-slot name="description">
            Update the department details.
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6">
                <x-jet-label for="source_id" value="Source ID" />
                <x-jet-input id="source_id" disabled type="text" class="mt-1 block w-full" wire:model="source_id" required />
                <x-jet-input-error for="source_id" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="name" value="Department Name" />
                <x-jet-input id="name"  type="text" class="mt-1 block w-full" wire:model="name" required />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="ancestors" value="Ancestors" />
                <x-jet-input id="ancestors" disabled type="text" class="mt-1 block w-full" wire:model="ancestors" required />
                <x-jet-input-error for="ancestors" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="parent" value="Parent" />
                <x-jet-input id="parent" disabled type="text" class="mt-1 block w-full" wire:model="parent" required />
                <x-jet-input-error for="parent" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="server" value="Server" />
                <x-jet-input id="server" type="text" class="mt-1 block w-full" wire:model="server" required />
                <x-jet-input-error for="server" class="mt-2" />
            </div>


            @if ($department->client == '0' || is_null($department->client))
            @livewire('department.client-update')
            @else
            <div class="col-span-6">
                <x-jet-label for="client" value="Client" />
                <x-jet-input id="client" type="text" disabled class="mt-1 block w-full" wire:model="client" required />
                <x-jet-input-error for="client" class="mt-2" />
            </div>

            @endif




        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="ml-3" on="departmentSaved">
                {{ __('Departement Data Saved. ') }}
            </x-jet-action-message>

            <x-jet-button>
                Save
            </x-jet-button>


        </x-slot>
    </x-jet-form-section>
</div>
