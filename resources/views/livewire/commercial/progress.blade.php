<div wire:poll>
    @if ($model->status == 'draft' || ($model->status == 'unpaid' && $model_type == 'commission'))
        @if (auth()->user()->isSuper || (auth()->user()->team && str_contains(auth()->user()->isNoAdmin->role, 'admin')))
        <div class="px-4 py-5 bg-white dark:bg-slate-600 sm:p-6 shadow sm:rounded-md">

            <div class="sm:px-0">
                <h3 class="text-base font-bold text-gray-900 dark:text-slate-300">Submission Process</h3>
            </div>
            <div class="w-auto text-center mt-4">
                <x-jet-button :disabled="!userAccess('QUOTATION', 'update')" wire:click="submit" class="hover:bg-green-700 bg-green-700">
                    {{ $approvals->count() > 0 ? __('Re-Submit') : __('Submit') }}
                </x-jet-button>
            </div>
            @if ($errorMessage)
                <div class="text-red-500 p-2">
                    {!! $errorMessage !!}
                </div>
            @endif
        </div>
        <br>
    @endif

    @endif

    @if ($approvals->count() > 0)
        <div
            class="{{ auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin' ? 'sm:block' : '' }} sm:block hidden px-4 py-5 bg-white dark:bg-slate-600 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            <div class="px-4 pb-6 sm:px-0">
                <h3 class="text-sm font-bold text-gray-900 dark:text-slate-300">Approval Process</h3>
            </div>
            <div>
                <ol class="relative">
                    @foreach ($approvals as $approval)
                        <li
                            class=" {{ $approval->status != null ? 'border-l-2 border-blue-600' : 'border-gray-300' }} pl-6 pb-4">
                            @if ($approval->status == 'decline')
                                <div class="1 absolute w-6 h-6 bg-yellow-600 rounded-full -left-3 border border-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="m-auto mt-1 h-3 w-3 text-white"
                                        fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                            @elseif($approval->status != 'submited')
                                <div
                                    class="2 absolute w-6 h-6 {{ $approval->status == null ? 'bg-gray-300 dark:bg-slate-600' : 'bg-blue-600' }} rounded-full -left-3 border border-white dark:border-blue-900 dark:bg-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="m-auto mt-1 h-3 w-3 text-white"
                                        fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                            @else
                                <div
                                    class="3 absolute w-6 h-6 {{ $approval->status == null ? 'bg-gray-300' : 'bg-blue-600' }} rounded-full -left-3 border border-white dark:border-blue-900 dark:bg-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="m-auto mt-1 h-4 w-3 text-white"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex gap-2 justify-between">
                                <h3 class="mt-0 text-sm font-semibold text-gray-900 dark:text-white capitalize">
                                    {{ $approval->status != 'submited' ? @$approval->role->name : @$approval->user->name }}
                                </h3>
                                <p class="mt-0 text-sm font-semibolde text-gray-900 dark:text-gray-300 capitalize">
                                    {{ $approval->status }}</p>
                            </div>
                            @if ($approval->status != null)
                                <div class="flex justify-end">
                                    @if ($approval->user_id)
                                        <p
                                            class="mb-2 mt-2 text-xs font-bold leading-none text-gray-400 dark:text-gray-500 flex justify-between">
                                            <img class="h-4 w-4 rounded-full object-cover"
                                                src="{{ $approval->user->profile_photo_url }}"
                                                alt="{{ $approval->user->name }}" />
                                            <span
                                                class="mx-1">{{ $approval->user_id ? $approval->user->name : '' }}</span>
                                        </p>
                                    @endif
                                    <p class="text-right flex justify-around">
                                        <time
                                            class="mb-3 mt-2 text-xs font-thin leading-none text-gray-400 dark:text-gray-500">{{ $approval->updated_at->format('dM-y H:i') }}</time>
                                    </p>
                                </div>
                                @if ($approval->comment != '')
                                    <p
                                        class="text-xs font-normal text-gray-500 dark:text-gray-400 bg-gray-300 rounded-sm px-2 py-1">
                                        {{ $approval->comment }}</p>
                                @endif
                            @endif
                        </li>
                    @endforeach

                    @if ($approval->status != null)
                        <li class="ml-5 mb-6">
                            <div
                                class="absolute w-6 h-6 bg-blue-600 rounded-full -left-3 border border-white dark:border-blue-900 dark:bg-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="m-auto mt-1 h-3 w-3 text-white"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white ">Notified</h3>
                                <ul class="text-left list-disc ml-4" style=" list-style-type: disclosure-closed; ">
                                    @foreach ($approvals->groupBy('user_id') as $approval)
                                        <li
                                            class="mb-2 mt-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-300 capitalize">
                                            {{ $approval[0]->user->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                </ol>
            </div>
        </div>

        <!-- The offcanvas component -->
        <!-- FOR MOBILE USAGE DESIGN -->
        <div class="{{ auth()->user()->isSuper || (auth()->user()->team && str_contains(Auth::user()->activeRole->role->name, 'Admin')) ? 'block' : '' }} block sm:hidden"
            x-data="{ offcanvas: false }">
            @if (auth()->user()->isSuper || (auth()->user()->team && str_contains(Auth::user()->activeRole->role->name, 'Admin')))
                <button class="fixed top-52 right-0 bg-blue-100 p-1 text-sm text-gray-400"
                    @click="offycanvas = true">Approval</button>
            @endif

            <section x-show="offcanvas" class="fixed inset-y-0 right-0 z-50 flex">
                <div class="w-60 max-w-sm">
                    <div class="flex flex-col h-full divide-y divide-gray-200 bg-gray-100 dark:bg-slate-600">
                        <div class="overflow-y-scroll">
                            <header class="flex items-center justify-between h-16 pl-6">
                                <span class="text-sm font-medium tracking-widest uppercase">
                                    Approval Process
                                </span>

                                <button aria-label="Close menu" class="w-16 h-16 border-l border-gray-200"
                                    type="button" @click="offcanvas = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </header>

                            <nav
                                class="flex flex-col text-sm font-medium text-gray-500 border-t border-b border-gray-200 divide-y divide-gray-200">
                                <div class="p-8">
                                    <ol class="relative">
                                        @foreach ($approvals as $approval)
                                            <li
                                                class=" {{ $approval->status != null ? 'border-l-2 border-blue-600' : 'border-gray-300' }} pl-6 pb-4">
                                                @if ($approval->status == 'decline')
                                                    <div
                                                        class="absolute w-6 h-6 bg-yellow-600 rounded-full -left-3 border border-white dark:border-blue-900 dark:bg-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="m-auto mt-1 h-3 w-3 text-white" fill="none"
                                                            viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                        </svg>
                                                    </div>
                                                @elseif($approval->status != 'submited')
                                                    <div
                                                        class="absolute w-6 h-6 {{ $approval->status == 'approved' ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full -left-3 border border-white dark:border-blue-900 dark:bg-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="m-auto mt-1 h-3 w-3 text-white" fill="none"
                                                            viewBox="0 0 24 24" stroke="white" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div
                                                        class="absolute w-6 h-6 bg-blue-600 rounded-full -left-3 border border-white dark:border-blue-900 dark:bg-blue-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="m-auto mt-1 h-4 w-3 text-white" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                                        </svg>
                                                    </div>
                                                @endif

                                                <div class="flex gap-2">
                                                    <h3
                                                        class="mt-0 text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $approval->status != 'submited' ? @$approval->role->name : @$approval->user->name }}
                                                    </h3>
                                                    <p
                                                        class="mt-0 text-sm font-semibolde text-gray-900 dark:text-gray-500 capitalize">
                                                        {{ $approval->status }}</p>
                                                </div>

                                                @if ($approval->status != null)
                                                    <div class="flex justify-end">
                                                        @if ($approval->user_id)
                                                            <p
                                                                class="mb-2 mt-2 text-xs font-bold leading-none text-gray-400 dark:text-gray-500 flex justify-between">
                                                                <img class="h-4 w-4 rounded-full object-cover"
                                                                    src="{{ $approval->user->profile_photo_url }}"
                                                                    alt="{{ $approval->user->name }}" />
                                                                <span
                                                                    class="mx-1">{{ $approval->user_id ? $approval->user->name : '' }}</span>
                                                            </p>
                                                        @endif
                                                        <p class="text-right flex justify-around">
                                                            <time
                                                                class="mb-3 mt-2 text-xs font-thin leading-none text-gray-400 dark:text-gray-500">{{ $approval->updated_at->format('dM-y H:i') }}</time>
                                                        </p>
                                                    </div>
                                                    @if ($approval->comment != '')
                                                        <p
                                                            class="text-xs font-normal text-gray-500 dark:text-gray-400 bg-gray-300 rounded-sm px-2 py-1">
                                                            {{ $approval->comment }}</p>
                                                    @endif
                                                @endif
                                            </li>
                                        @endforeach

                                        @if ($approval->status != null)
                                            <li class="ml-5 mb-6">
                                                <div
                                                    class="absolute w-6 h-6 {{ $approval->status == 'approved' ? 'bg-blue-600' : 'bg-gray-300' }} rounded-full -left-3 border border-white dark:border-blue-900 dark:bg-blue-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="m-auto mt-1 h-3 w-3 text-white" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path
                                                            d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        Notified</h3>
                                                    <ul class="text-left">
                                                        @foreach ($approvals->groupBy('user_id') as $approval)
                                                            <li
                                                                class="mb-2 mt-1 text-xs font-normal leading-none text-gray-400 dark:text-gray-300 capitalize">
                                                                {{ $approval[0]->user->name }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endif
                                    </ol>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endif

    @if (auth()->user()->isSuper ||
            (auth()->user()->team &&
                str_contains(Auth::user()->activeRole->role->name, 'Admin') &&
                $model->status == 'approved'))
        <div
            class="px-4 py-5 bg-white text-center dark:bg-slate-600 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md mt-4">
            <x-jet-button :disabled="!userAccess('QUOTATION', 'update')" wire:click="activated" class="hover:bg-green-700 bg-green-500 px-2">
                {{ __('Activated') }}
            </x-jet-button>
        </div>
    @endif

    @if ($model->status != 'draft' && $approval && $model->approval && empty($approval->status))
        @if ($model->status == 'submit' || $model->status == 'submit')
            <!--  -->
            <div class="px-4 py-5 bg-white dark:bg-slate-600 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md mt-4">
                <div class="sm:px-0">
                    <h3 class="text-base font-medium text-gray-900 dark:text-slate-300">
                        {{ $model->approval->task != '' ? $model->approval->task : 'Next Process' }}</h3>
                </div>
                <div class="col-span-12 sm:col-span-1">
                    <x-jet-label for="remark" value="{{ __('Remark') }}" />
                    <x-jet-input id="remark" type="text" class="mt-1 block w-full text-xs"
                        wire:model="remark" />
                    <x-jet-input-error for="remark" class="mt-2" />
                </div>
                <div class="w-auto text-center mt-4 flex gap-2">
                    <button type="submit" wire:click="decline"
                        class="inline-flex items-center px-2 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition hover:bg-red-400 bg-red-300"
                        wire:click="submit">
                        {{ __('Decline') }}
                    </button>
                    @if ($model->approval->task == 'Releasor' || $model->approval->task == 'Releasing')
                        <x-jet-button wire:click="next('released')" class="hover:bg-green-700 bg-green-500 px-2">
                            {{ __('Approve') }}
                        </x-jet-button>
                    @else
                        <x-jet-button wire:click="next('approved')" class="hover:bg-green-700 bg-green-500 px-2">
                            {{ __('Approve') }}
                        </x-jet-button>
                    @endif
                </div>

            </div>
        @endif

    @endif

    @foreach ($approvals as $key => $rev)
        @if ($key == 0)
            @if (
                ($rev->user_id == auth()->user()->id && $model->status == 'submit') ||
                    (auth()->user()->super->first() &&
                        auth()->user()->super->first()->role == 'superadmin' &&
                        $model->status == 'revision'))
                <div class="px-4 py-5 mt-4 bg-white dark:bg-slate-600 sm:p-6 shadow sm:rounded-md">
                    <x-jet-button wire:click="revise" class="hover:bg-yellow-700 bg-yellow-700">
                        Revise
                    </x-jet-button>
                </div>
            @endif
        @endif
    @endforeach

</div>
