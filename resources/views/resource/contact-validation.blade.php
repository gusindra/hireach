<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="grid grid-cols-12">
        @includeWhen(auth()->user(), 'menu.user-engagement', [])

        <div class="col-span-12 px-2 ml-24 mt-2">
            <header class="bg-white dark:bg-slate-900 flex">

                <ul
                    class="flex gap-1 flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400">
                    <li class="me-2">
                        <a href="{{ route('contact.index') }}"
                            class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                            Contact
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="{{ route('audience.index') }}"
                            class="inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                            Audience
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="{{ route('contactValidation.index') }}" aria-current="page"
                            class="inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg dark:bg-gray-800 dark:text-blue-500">
                            Contact Validation
                        </a>
                    </li>
                </ul>


            </header>
            <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-b-lg border">
                <div class="p-6 mx-auto">
                    <div class="flex justify-between">
                        <div class="pb-4 flex justify-between  w-full">
                            <div class="flex gap-2">
                                @livewire('validation-resource.add-contact')
                                @livewire('validation-resource.add-validation')
                                @livewire('validation-resource.convert-to-client')
                                <livewire:contact.export-result-contact />

                            </div>
                            <div>
                                @livewire('validation-resource.loading')
                            </div>


                        </div>
                    </div>
                    <div>
                        <livewire:table.contact-validation-table />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
