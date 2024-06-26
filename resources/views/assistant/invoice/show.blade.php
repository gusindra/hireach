<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Order') }}
        </h2>
    </x-slot>
    <header class="bg-white dark:bg-slate-900 dark:border-slate-600 border-b shadow">
        <div class="flex justify-between pt-2 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="justify-end flex mb-2">
                <div class="items-center justify-end px-2">
                    <div class="space-x-1 sm:-my-px">
                        <x-jet-nav-link href="{{ route('assistant') }}">
                            {{ __('Assistant') }}
                        </x-jet-nav-link>
                        <span class="inline-flex items-center px-1 pt-1 text-xs font-medium leading-5 text-gray-900 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <x-jet-nav-link href="{{ route('admin.invoice') }}">
                            {{ __('Invoice ') }}
                        </x-jet-nav-link>
                        <span class="inline-flex items-center px-1 pt-1 text-xs font-medium leading-5 text-gray-900 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <x-jet-nav-link href="#" :active="true">
                            {{ $order->no }}
                        </x-jet-nav-link>
                    </div>
                </div>
            </div>

            @if ($order->status == 'approved' || $order->status == 'unpaid' || $order->status == 'paid')
                <div class="justify-end flex">
                    @if ($order->commission)
                        <span class="inline-flex rounded-md mb-2">
                            <a href="{{ route('show.commission', [$order->commission->id]) }}"
                                class="inline-flex dark:bg-slate-800 dark:text-slate-300 items-center px-2 py-1 border text-xs leading-4 font-medium rounded-md text-gray-500  bg-gray-200 hover:bg-gray-300 hover:text-gray-700 focus:outline-none focus:bg-gray-400 active:bg-gray-400 transition">
                                View Commission
                            </a>
                        </span>
                    @endif
                    <div class="items-center justify-end px-2 text-right">
                        <x-jet-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md mb-2">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border text-xs leading-4 font-medium rounded-md text-gray-500  bg-gray-200 hover:bg-gray-300 hover:text-gray-700 focus:outline-none focus:bg-gray-400 active:bg-gray-400 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <div>
                                        <form>
                                            <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition"
                                                target="_blank"
                                                href="{{ route('commercial.print', ['type' => 'invoice', 'id' => $order->id]) }}">
                                                <div class="flex items-center justify-between">
                                                    <div class="truncate">Print</div>
                                                </div>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
            @endif
        </div>
    </header>
    <div>
        <div class="max-w-7xl mx-auto py-4 sm:px-6 lg:px-8 mb-6">
            @includeWhen(auth()->user()->super->first() && auth()->user()->super->first()->role == 'superadmin',
                'menu.admin-menu-order',
                []
            )
            @if ($order->status == 'paid' || $invoice->status == 'paid')
                <div class="bg-green-100 border sm:rounde border-green-500 text-green-700 px-4 py-3 mb-4"
                    role="alert">
                    <p class="font-bold capitalize">{{ $order->status }}</p>
                </div>
            @endif
            @if ($invoice->status == 'released')
                <div class="md:grid md:grid-cols-5 md:gap-4">
                    <div class="md:col-span-1 flex justify-between">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-slate-300">File Upload</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">
                                File information
                            </p>
                        </div>
                    </div>

                    <div class="mt-0 md:mt-0 md:col-span-4">
                        <div class="bg-white dark:bg-slate-600 shadow sm:rounded-md">
                            <div class="pt-4">
                                @livewire('file-upload', ['model' => 'invoice', 'model_id' => $invoice->id, 'status' => $invoice->status])
                            </div>
                        </div>
                    </div>
                </div>
                <x-jet-section-border />
            @endif

            <div class="md:grid md:grid-cols-5 md:gap-6">
                <iframe class="md:col-span-12 lg:col-span-4 w-full h-screen"
                    src="/admin/commercial/{{ $order->id }}/invoice/print"></iframe>

                <div class="justify-between lg:visible md:invisible"></div>
            </div>
        </div>
    </div>
</x-app-layout>
