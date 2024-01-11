<div>
    <button wire:click="actionShowModal" type="button"
        class="inline-block px-3 py-2 mt-2 mb-0 mr-auto font-bold text-center dark:text-white uppercase align-middle transition-all rounded-lg cursor-pointer lg:ml-auto lg:mr-0 lg:mt-0 hover:scale-102 active:opacity-85 hover:shadow-soft-xs   to-pink-500   text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 border "><i
            class="fa fa-list" aria-hidden="true"></i></button>

    <!-- Form Action Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Log') }}
        </x-slot>

        <x-slot name="content">
            <div
                class="relative flex flex-col w-full min-w-0 mb-0 break-words border-0 border-transparent rounded-2xl bg-clip-border">

                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Author</th>
                                    <th
                                        class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Remark</th>
                                    <th
                                        class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Updated At</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div class="flex flex-col justify-center">
                                                <p class="mb-0 leading-tight text-xs text-slate-400">
                                                {{$log->user->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <p class="mb-0 leading-tight text-xs text-slate-400">{{$log->remark}}</p>
                                    </td>
                                    <td
                                        class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="font-semibold leading-tight text-xs text-slate-400">{{$log->updated_at->format("d-m-Y H:i:s")}}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Close') }}
            </x-jet-secondary-button>

        </x-slot>
    </x-jet-dialog-modal>
</div>
