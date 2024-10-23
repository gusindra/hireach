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
                <x-jet-input id="source_id" type="text" class="mt-1 block w-full" wire:model="source_id" required />
                <x-jet-input-error for="source_id" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="name" value="Department Name" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model="name" required />
                <x-jet-input-error for="name" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="ancestors" value="Ancestors" />
                <x-jet-input id="ancestors" type="text" class="mt-1 block w-full" wire:model="ancestors" required />
                <x-jet-input-error for="ancestors" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="parent" value="Parent" />
                <x-jet-input id="parent" type="text" class="mt-1 block w-full" wire:model="parent" required />
                <x-jet-input-error for="parent" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="server" value="Server" />
                <x-jet-input id="server" type="text" class="mt-1 block w-full" wire:model="server" required />
                <x-jet-input-error for="server" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="clientSearch" value="Client" />
                <div x-data="{ open: false }" @click.away="open = false">
                    <input
                        type="text"
                        id="clientSearch"
                        class="mt-1 block w-full"
                        wire:model="clientSearch"
                        @focus="open = true"
                        @keydown.escape="open = false"
                        placeholder="Search for client"
                    />

                    <div x-show="open" class="absolute mt-1 w-full bg-white shadow-lg z-10">
                        @foreach($clients as $client)
                            <div
                                class="cursor-pointer hover:bg-gray-100 p-2"
                                @click="open = false; @this.selectClient({{ $client->id }})"
                            >
                                {{ $client->name }} |  {{ $client->phone }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-jet-input-error for="client_id" class="mt-2" />
            </div>
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
