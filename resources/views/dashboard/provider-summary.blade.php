<div class="max-w-9xl mx-auto">
    <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
        <div class="py-2 bg-opacity-10 grid grid-cols-1 md:grid-cols-1 gap-3">
            <div class="flex justify-between">
                <div class="w-full">
                    <div class="items-center hidden shadow rounded border">
                        <div class="ml-4 text-gray-600 dark:text-gray-300 leading-7 font-semibold text-3xl p-3">
                            <div class="text-sm text-gray-500 dark:text-gray-300">
                                <a href="#">MacroKiosk</a>
                            </div>
                            <div class="flex justify-between">
                                <div class="text-lg text-gray-600 dark:text-gray-300 leading-7 font-semibold ">
                                    <small>OTP Balance</small>
                                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                        <span class="text-2xl">Rp{{ masterSaldo() ? number_format(masterSaldo()) : 0 }}</span>
                                    </div>
                                </div>
                                <div class="ml-4 text-lg text-gray-600 dark:text-gray-300 leading-7 font-semibold ">
                                    <small>Non OTP Balance</small>
                                    <div class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                                        <span class="text-2xl">Rp{{ masterSaldo('non') ? number_format(masterSaldo('non')) : 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                                <!-- Provider Balances & Usages -->
            <div class="mt-4 shadow-lg rounded-lg border p-4 bg-white dark:bg-slate-800">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Provider Balances & Usages</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($providers as $provider)
                        <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 transition duration-300 ease-in-out hover:shadow-xl transform hover:-translate-y-1">
                            <div class="text-gray-700 dark:text-gray-300 text-sm font-medium">{{ strtoupper($provider->name) }}</div>

                            <div class="text-xl text-gray-800 dark:text-white font-semibold mt-2">
                                Balance:
                                <span class="text-green-500">Rp{{ number_format($provider->latestBalance - $provider->totalUsage) }}</span>
                            </div>

                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                <span class="font-medium">Usage: </span>
                                <span class="text-red-500">Rp{{ number_format($provider->totalUsage) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


                </div>
            </div>
        </div>
    </div>
</div>
