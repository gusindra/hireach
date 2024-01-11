<div>
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3 flex-0">
            <div class="relative flex flex-col min-w-0 overflow-none break-words bg-white border-0 dark:bg-gray-950 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex flex-auto px-6 pt-3">
                    <div class="w-4/12 text-left flex-grow sm:w-3/12 md:w-2/12 ">
                        <a wire:click="actionShowModal" title="Add Member" href="javascript:;" class="ease-soft-in-out w-14 h-14 text-sm rounded-circle bg-gradient-to-tl from-purple-700 to-slate-800 inline-flex items-center justify-center border-0 text-white transition-all duration-200">
                            <i class="text-white fas fa-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                    @foreach($team->agents as $member)
                    <div class="w-4/12 text-left flex-grow sm:w-3/12 md:w-2/12">
                        <a href="{{route('user.show', $member->user->id)}}?v=1" class="ease-soft-in-out w-14 h-14 text-sm rounded-circle inline-flex items-center justify-center border border-solid border-green-500 text-white transition-all duration-200">
                            <img title="{{$member->user->email}}" src="{{$member->user->profile_photo_url}}" alt="Image placeholder" class="w-full p-1 rounded-circle">
                        </a>
                        <p class="mb-0 leading-normal text-xs dark:text-white dark:opacity-60">{{$member->user->name}}</p>
                        @foreach($member->userRole as $key => $role)
                        <p class="text-xs opacity-40" style="font-size: xx-small;">({{$role->role->name}})</p>
                        @endforeach
                    </div>
                    @endforeach

                    @if ($team->teamInvitations->isNotEmpty() && ($member->user->team->role == 'admin'))
                        @foreach($team->teamInvitations as $invitation)
                        <div class="w-4/12 text-left flex-grow sm:w-3/12 md:w-2/12 ">
                            <a href="javascript:;" class="ease-soft-in-out w-14 h-14 text-sm rounded-circle inline-flex items-center justify-center border border-solid border-gray-500 text-white transition-all duration-200">
                                <img title="{{$invitation->email}}" src="https://ui-avatars.com/api/?name={{$invitation->email}}&amp;color=7F9CF5&amp;background=EBF4FF" alt="Image placeholder" class="w-full p-1 rounded-circle">
                            </a>
                            <p class="mb-0 leading-normal text-xs dark:text-white dark:opacity-60">{{$invitation->email}}</p>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Invite User') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="text" class="mt-1 block w-full" wire:model.debunce.800ms="email" autofocus />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4 p-3">
                <x-jet-label for="message" value="{{ __('Message') }}" />
                <x-textarea id="message" type="text" class="mt-1 block w-full dark:bg-slate-800 border border-gray-300" wire:model.debunce.800ms="message" autofocus></x-textarea>
                <x-jet-input-error for="message" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="invite" wire:loading.attr="disabled">
                {{ __('Send Invitation') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
