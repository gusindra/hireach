<div>
    <x-jet-section-border />

    <!-- Add Team Member -->
    <div class="mt-10 sm:mt-0">
        <x-jet-form-section submit="addRoleMember">
            <x-slot name="title">
                {{ __('Add User') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add a new user to your role, allowing them to collaborate with you.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <div class="max-w-xl text-sm text-gray-600 dark:text-slate-300">
                        {{ __('Please provide the email address of the person you would like to add to this role.') }}
                    </div>
                </div>

                <!-- Member Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="inviteEmail" value="{{ __('Email') }}" />
                    <x-jet-input id="inviteEmail" type="email" class="mt-1 block w-full" wire:model="inviteEmail"
                        wire:model.defer="inviteEmail" wire:model.debounce.800ms="inviteEmail" />
                    <x-jet-input-error for="inviteEmail" class="mt-2" />
                </div>

            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Added.') }}
                </x-jet-action-message>

                <x-jet-button :disabled="!userAccess('ROLE', 'update')">
                    {{ __('Add') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </div>

    @if (count($invites) > 0)
        <x-jet-section-border />
        <!-- Team Member Invitations -->
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Pending Invitations') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        <!-- foreach invite user -->
                        @foreach ($invites as $invite)
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600 dark:text-slate-300">{{ $invite->email }}</div>

                                <div class="flex items-center">
                                    <!-- Cancel Team Invitation -->
                                    <button :disabled="!userAccess('ROLE', 'delete')"
                                        class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                        wire:click="cancelTeamInvitation({{ $invite->id }})">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="deleted">
                        {{ __('Deleted.') }}
                    </x-jet-action-message>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    @if (count($users) > 0)
        <x-jet-section-border />
        <!-- Manage Team Members -->
        <div class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Users') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the people that are part of this team.') }}
                </x-slot>

                <!-- Team Member List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        <!-- foreach -->
                        @foreach ($users as $user)
                            @if ($user->user)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img class="w-8 h-8 rounded-full" src="{{ $user->user->profile_photo_url }}"
                                            alt="name">
                                        <div class="ml-4">{{ $user->user->email }}</div>
                                        <div class="ml-4">( {{ $user->user->name }} )</div>
                                    </div>

                                    <div class="flex items-center">
                                        <!-- Remove Team Member -->
                                        <button class="cursor-pointer ml-6 text-sm text-red-500"
                                            wire:click="confirmTeamMemberRemoval({{ $user->id }})">
                                            {{ __('Remove') }}
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>
    @endif

    <!-- Remove Team Member Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Remove Team Member') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this person from the team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Copy Link Modal -->
    <x-jet-confirmation-modal wire:model="showCopyLinkModal">
        <x-slot name="title">
            {{ __('Copy Invitation Link') }}
        </x-slot>

        <x-slot name="content">
            <div class="flex items-center justify-between">
                <div class="w-full max-w-xs">
                    <x-jet-input id="inviteLink" type="text" class="mt-1 block w-full" wire:model.defer="inviteLink"
                        readonly />
                </div>
                <div>
                    <button class="ml-2 px-4 py-2 bg-yellow-800 w-16 text-white rounded-md flex items-center"
                        onclick="copyToClipboard()">
                        {{ __('Copy') }}
                    </button>
                </div>
            </div>

            <div id="copyMessage" class="mt-2 text-green-600 dark:text-green-400 hidden flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Link copied!') }}
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showCopyLinkModal')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <script>
        function copyToClipboard() {
            var copyText = document.getElementById('inviteLink');
            var message = document.getElementById('copyMessage');

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            document.execCommand('copy');


            message.classList.remove('hidden');

            setTimeout(function() {
                message.classList.add('hidden');
            }, 2000);
        }
    </script>


</div>
