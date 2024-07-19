<div>
    <!-- Add Team Member -->
    @if ($team)
        <x-jet-form-section submit="inviteTeamMember">
            <x-slot name="title">
                {{ __('Add Team Member') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Add a new team member to your team, allowing them to collaborate with you.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6">
                    <div class="max-w-xl text-sm text-gray-600 dark:text-slate-300">
                        {{ __('Please provide the email address of the person you would like to add to this team.') }}
                    </div>
                </div>

                <!-- Member Email -->
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>

                <!-- Role -->
                @if (!empty($roles))
                    <div class="col-span-6 lg:col-span-4">
                        <x-jet-label for="role" value="{{ __('Role') }}" />
                        <x-jet-input-error for="role" class="mt-2" />

                        <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                            @foreach ($roles as $roleType => $roleList)
                            @foreach ($roleList as $roleItem)
                                <button type="button" class="relative px-4 py-3 inline-flex w-full rounded-lg border-b-2 {{ $roleItem['key'] == $role ? 'border-blue-400' : 'border-transparent' }} focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue"
                                    wire:click="$set('role', '{{ $roleItem['key'] }}')">
                                    <div>
                                        <div class="flex items-center">
                                            <div class="text-sm {{ $roleItem['key'] == $role ? 'text-black font-semibold' : 'text-gray-600 dark:text-slate-300' }}">
                                                {{ $roleItem['name'] }}
                                            </div>

                                            @if ($roleItem['key'] == $role)
                                                <svg class="ml-2 h-5 w-5 text-blue-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>

                                        <div class="mt-2 text-xs {{ $roleItem['key'] == $role ? 'text-black' : 'text-gray-600 dark:text-slate-300' }}">
                                            {{ $roleItem['description'] }}
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        @endforeach

                        </div>
                    </div>
                @endif
            </x-slot>

            <x-slot name="actions">
                <x-jet-action-message class="mr-3" on="saved">
                    {{ __('Added.') }}
                </x-jet-action-message>

                <x-jet-button>
                    {{ __('Add') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    @endif

    <!-- Invitation Link Modal -->
    <x-jet-dialog-modal wire:model="showingInvitationLinkModal">
        <x-slot name="title">
            {{ __('Invitation Link') }}
        </x-slot>

        <x-slot name="content">
            <p>{{ __('The invitation link to join the team has been created successfully. Copy and share this link with the new member.') }}</p>
            <div class="mt-4 flex items-center">
                <x-jet-input id="invitationLink" type="text" class="w-full" readonly wire:model.defer="invitationLink" />
                <button
                    id="copyButton"
                    class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50"
                    wire:click="copyInvitationLink">
                    {{ __('Copy') }}
                </button>
            </div>
            @if ($copied)
                <p class="mt-2 text-green-600">{{ __('Copied Successfully!') }}</p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showingInvitationLinkModal')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

    <script>
        document.addEventListener('copySuccess', function () {
            setTimeout(() => {
                @this.copied = false; // Reset the copied status after showing the message
            }, 2000); // Adjust the timeout duration as needed
        });

        function copyToClipboard() {
            const input = document.getElementById('invitationLink');
            input.select();
            document.execCommand('copy');
            @this.copyInvitationLink();
        }

        document.getElementById('copyButton').addEventListener('click', copyToClipboard);
    </script>










  @if ($team->teamInvitations->isNotEmpty() && (Gate::check('addTeamMember', $team) || ($this->user->team && $this->user->team->role == 'admin')))
        <x-jet-section-border />

        <!-- Team Member Invitations -->
        <div wire:poll.1s class="mt-10 sm:mt-0">
            <x-jet-action-section>
                <x-slot name="title">
                    {{ __('Pending Team Invitations') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->teamInvitations as $invitation)
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600 dark:text-slate-300">{{ $invitation->email }}</div>

                                <div class="flex items-center">
                                    @if (Gate::check('removeTeamMember', $team))
                                        <!-- Cancel Team Invitation -->
                                        <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                    wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                            {{ __('Cancel') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-jet-action-section>
        </div>

    @endif




</div>
