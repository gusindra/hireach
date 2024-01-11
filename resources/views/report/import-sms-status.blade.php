<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Status Detail') }}
        </h2>
    </x-slot>
    <!-- Topup Dashboard -->
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-2 bg-white dark:bg-slate-600 border-b border-gray-200">
                    <div class="mt-2 text-2xl">
                        Update Status Bulk Sms
                    </div>
                </div>

                <div class="py-3">
                    <div class="md:grid md:grid-cols-3 md:gap-6 mt-8 sm:mt-0">
                        <div class="md:col-span-1 px-4 py-5 bg-white dark:bg-slate-600 sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                            <form class="mt-3 p-6" method="POST" action="{{ route('admin.post.import.status') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="px-4 sm:px-0 mb-4">
                                    <h3 class="font-semibold text-xl text-gray-900 dark:text-slate-300 mb-4">Upload SMS file csv</h3>

                                    <label>CSV File</label>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-slate-300 flex justify-between">
                                        <input type="file" name="csv" required>
                                    </p>
                                </div>

                                <div class="flex items-center justify-end py-3 sm:rounded-bl-md sm:rounded-br-md">
                                    <div x-data="{ shown: false, timeout: null }" x-init="window.livewire.find('fDi3Mot18qtGazaO7OVn').on('fail', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000);  })" x-show.transition.opacity.out.duration.1500ms="shown" style="display: none;" class="text-xs text-gray-600 dark:text-slate-300 mr-3">
                                        Something is wrong
                                    </div>

                                    <button type="submit" class="w-full items-center py-2 bg-green-800 border border-green-800 dark:border-white/40 dark:bg-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:shadow-outline-gray disabled:opacity-25 transition">
                                        Upload
                                    </button>
                                </div>
                            </form>
                        </div> 
                            <div class="mt-2 md:mt-0 md:col-span-2">
                                <div class="px-4 py-5 bg-white dark:bg-slate-600 sm:p-10 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                    <div class="flex flex-col">
                                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                                <div class="overflow-hidden">
                                                    <table class="min-w-full text-left text-sm font-light">
                                                        <thead class="border-b font-medium dark:border-neutral-500">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-4">Updated</th>
                                                                <th scope="col" class="px-6 py-4">Pass</th>
                                                                <th scope="col" class="px-6 py-4">Not Match</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="border-b dark:border-neutral-500">
                                                                <td class="px-6 py-4"> {{@$updated}}</td>
                                                                <td class="px-6 py-4"> {{@$unpass}}</td>
                                                                <td class="px-6 py-4"> {{@$notmatch}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                    </div>

                </div>
            </div>
        </div>
    </div>
    <x-jet-section-border/>
</x-app-layout>
