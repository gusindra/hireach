<div class="p-4 mb-4 bg-white shadow rounded-lg border border-gray-200">

    <x-jet-form-section submit="generateToken">
        <x-slot name="title">
            {{ __('Generate API Token') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Generate a new API token for the user with specific permissions.') }}
        </x-slot>

        <x-slot name="form">
            <div class="flex flex-col space-y-6 mt-4">
                <div>
                    <x-jet-label for="tokenName" value="Token Name" />
                    <x-jet-input id="tokenName" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500" wire:model="tokenName" placeholder="Enter token name" style="min-width: 300px;" />
                    @error('tokenName') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-jet-label for="permissions" value="Permissions" />
                    <div class="grid grid-cols-2 gap-4 mt-2"> <!-- Use grid with 2 columns -->
                        @foreach ($availablePermissions as $permission)
                            <label class="flex items-center"> <!-- Removed width class -->
                                <input type="checkbox" value="{{ $permission }}" wire:model="permissions" class="form-checkbox bg-gray-100 border-gray-300 rounded h-5 w-5 text-indigo-600">
                                <span class="ml-2 text-gray-700">{{ ucfirst($permission) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('permissions') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-button wire:loading.attr="disabled" class="mt-4">
                {{ __('Generate Token') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
    <x-jet-section-border />
    <!-- Modal for Token Generated -->
    <x-jet-dialog-modal wire:model="showingTokenModal">
        <x-slot name="title">
            API Token Generated
        </x-slot>

        <x-slot name="content">
            <p class="mt-2 text-gray-700">Your API token has been successfully generated. Please save this token as it will not be shown again.</p>
            <div class="mt-4 p-3 bg-gray-100 rounded">
                <strong>Your Token:</strong>
                <code class="block mt-1 bg-gray-200 p-2 rounded">{{ $generatedToken }}</code>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeModal">
                Close
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <!-- Show Manage API Tokens only if tokens exist -->
    @if ($tokens->isNotEmpty())
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Manage API Tokens') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('You may delete any of your existing tokens if they are no longer needed.') }}
                </x-slot>

                <!-- API Token List -->
                <x-slot name="content">
                    @foreach ($tokens as $token)

                        <div class="flex justify-between p-3 items-center">
                            <div>
                                {{ $token->name }}
                            </div>
                            <div class="flex gap-3">

                                <div>
                                    {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : ' ' }}
                                </div>
                                <a wire:click="editPermissions({{ $token->id }})" class="text-base text-gray-600 underline cursor-pointer">
                                    Permissions
                                </a>
                                <a wire:click="deleteToken({{ $token->id }})" class="text-base text-red-500 cursor-pointer">
                                    Delete
                                </a>

                            </div>
                        </div>

                        @endforeach
                </x-slot>
            </x-jet-action-section>
        </div>

    @endif

    <x-jet-section-border />

    <!-- Modal for Editing Token Permissions -->
    <x-jet-dialog-modal wire:model="showingEditPermissionsModal">
        <x-slot name="title">
            {{ __('Edit Permissions') }}
        </x-slot>

        <x-slot name="content">
            <p class="mt-2 text-gray-700">Select the permissions for the token:</p>
            <div class="flex flex-wrap mt-4">
                @foreach ($availablePermissions as $permission)
                    <label class="flex items-center w-1/2"> <!-- Set width to half -->
                        <input type="checkbox" value="{{ $permission }}" wire:model="currentPermissions" class="form-checkbox bg-gray-100 border-gray-300 rounded h-5 w-5 text-indigo-600">
                        <span class="ml-2 text-gray-700">{{ ucfirst($permission) }}</span>
                    </label>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="closeEditPermissionsModal">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
            <x-jet-button class="ml-2" wire:click="updatePermissions">
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
