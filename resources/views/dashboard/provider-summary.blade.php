    <div class="max-w-9xl mx-auto">
        <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
            <div class="py-2 bg-opacity-10 grid grid-cols-1 md:grid-cols-1 gap-3">
                <div class="flex justify-between">
                    <div class="w-full">
                        <div class="items-center shadow rounded border">
                        <div class="ml-4 text-gray-600 dark:text-gray-300 leading-7 font-semibold text-3xl p-3">
                                <div class="text-sm text-gray-500 dark:text-gray-300">
                                    <a href="#">MacroKiosk</a>
                                </div>
                                <div class="flex justify-between">
                                    <div class="text-lg text-gray-600 dark:text-gray-300 leading-7 font-semibold ">
                                        <small>OTP Balance</small>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                            <span class="text-2xl">Rp{{masterSaldo() ? number_format(masterSaldo()) : 0}}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 text-lg text-gray-600 dark:text-gray-300 leading-7 font-semibold ">
                                        <small>Non OTP Balance</small>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                            <span class="text-2xl">Rp{{masterSaldo('non') ? number_format(masterSaldo('non')) : 0}}</span>
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
