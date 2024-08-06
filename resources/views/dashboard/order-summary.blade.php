    <div class="max-w-9xl mx-auto">
        <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
            <div class="py-2 bg-opacity-10 grid grid-cols-1 md:grid-cols-1 gap-3">
                <div class="flex justify-between">
                    <div class="w-full">
                        <div class="items-center shadow rounded border">
                            <div class="ml-4 text-gray-600 dark:text-gray-300 leading-7 font-semibold text-3xl p-3">
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    <a href="#">Order Summary</a>
                                </div>
                                <div class="flex justify-between">
                                    <div class="text-lg text-gray-600 dark:text-gray-300 leading-7 font-semibold ">
                                        <small>Draft</small>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                            <span
                                                class="text-2xl">{{ masterOrder('draft') ? masterOrder('draft') : 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 text-lg text-gray-600 dark:text-gray-300 leading-7 font-semibold ">
                                        <small>Unpaid</small>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                            <span
                                                class="text-2xl">{{ masterOrder('unpaid') ? masterOrder('unpaid') : 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 text-lg text-gray-600 dark:text-gray-300 leading-7 font-semibold ">
                                        <small>Paid</small>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                            <span
                                                class="text-2xl">{{ masterOrder('paid') ? masterOrder('paid') : 0 }}</span>
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
