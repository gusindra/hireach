<div>
    <!-- Button to open modal -->
    @if($disabled)
    <x-jet-button disabled wire:click="openModal">Add KTP</x-jet-button>
    @else
    <x-jet-button wire:click="openModal">Add KTP</x-jet-button>
    <!-- Jetstream Modal -->
    <x-jet-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Upload KTP File
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="uploadFile" enctype="multipart/form-data">
                <div class="mt-4">
                    <x-jet-label for="file" value="Select File" />
                    <input type="file" id="file" wire:model="file"
                        class="mt-2 border-gray-300 rounded-md shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    <x-jet-input-error for="file" class="mt-2" />
                </div>
            </form>
            <div class="my-4 p-4 bg-slate-50">
                <div class="text-sm font-bold mb-2">Sample</div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center border w-4"> </th>
                                <th scope="col" class="px-6 py-3 text-center border">
                                   A
                                </th>
                                <th scope="col" class="px-6 py-3 text-center border">
                                    B
                                </th>
                                <th scope="col" class="px-6 py-3 text-center border">
                                    C
                                </th>
                                <th scope="col" class="px-6 py-3 text-center border">
                                   D
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-2 font-medium bg-gray-100 text-gray-900 whitespace-nowrap dark:text-white">1</th>
                                <td class="px-6 py-2 border">
                                    no_ktp
                                </td>
                                <td class="px-6 py-2 border"> </td>
                                <td class="px-6 py-2 border"> </td>
                            </tr>
                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-2 font-medium bg-gray-100 text-gray-900 whitespace-nowrap dark:text-white">2</th>
                                <td class="px-6 py-2 border">
                                    12070254xxxx0007
                                </td>
                                <td class="px-6 py-2 border"> </td>
                                <td class="px-6 py-2 border"> </td>
                            </tr>
                            <tr class="bg-white border dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-2 font-medium bg-gray-100 text-gray-900 whitespace-nowrap dark:text-white">...</th>
                                <td class="px-6 py-2 border">
                                    ....
                                </td>
                                <td class="px-6 py-2 border"> </td>
                                <td class="px-6 py-2 border"> </td>
                            </tr>
                            <tr class="bg-white border dark:bg-gray-800">
                                <th scope="row" class="px-6 py-2 font-medium bg-gray-100 text-gray-900 whitespace-nowrap dark:text-white">1000</th>
                                <td class="px-6 py-2 border">
                                    12070430xxxx0001
                                </td>
                                <td class="px-6 py-2 border"> </td>
                                <td class="px-6 py-2 border"> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </x-slot>

        <!-- Footer for modal actions -->
        <x-slot name="footer">
            <div class="mt-4 flex justify-end">
                <x-jet-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                    Cancel
                </x-jet-secondary-button>
                <x-jet-action-message class="mr-3" on="no_balance">
                    {{ __('Your balance is not enough') }}
                </x-jet-action-message>
                <x-jet-button class="ml-2" wire:click="uploadFile" wire:loading.attr="disabled">
                    Upload
                </x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>
    @endif
</div>
