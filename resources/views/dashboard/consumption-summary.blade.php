<div class="max-w-9xl mx-auto">
    <div class="bg-white dark:bg-slate-600 overflow-hidden sm:rounded-lg">
        <div class="py-2 bg-opacity-10 grid grid-cols-1 md:grid-cols-1 gap-3">
            <div class="flex justify-between">
                <div class="w-full">

                    <div class="mt-4 shadow-lg rounded-lg border p-4 bg-white dark:bg-slate-800">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Consumption Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                                <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 transition duration-300 ease-in-out hover:shadow-xl transform hover:-translate-y-1">
                                    <div class="text-gray-700 dark:text-gray-300 text-sm font-medium">All Consumption</div>
                                    <div class="text-xl text-gray-800 dark:text-white font-semibold mt-2">
                                        <span class="text-green-500">{{$all}}</span>
                                    </div>
                                </div>

                                <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 transition duration-300 ease-in-out hover:shadow-xl transform hover:-translate-y-1">
                                    <div class="text-gray-700 dark:text-gray-300 text-sm font-medium">One Way</div>
                                    <div class="text-xl text-gray-800 dark:text-white font-semibold mt-2">
                                        <span class="text-green-500">{{$oneWay}}</span>
                                    </div>
                                </div>

                                <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 transition duration-300 ease-in-out hover:shadow-xl transform hover:-translate-y-1">
                                    <div class="text-gray-700 dark:text-gray-300 text-sm font-medium">Two Way</div>
                                    <div class="text-xl text-gray-800 dark:text-white font-semibold mt-2">
                                        <span class="text-green-500">{{$twoWay}}</span>
                                    </div>
                                </div>



                        </div>
                    </div>

                            <!-- Provider Balances & Usages -->
                            <div class="mt-4 shadow-lg rounded-lg border p-4 bg-white dark:bg-slate-800">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Provider Consumption</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    @foreach ($providers as $provider)
                                        <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-4 transition duration-300 ease-in-out hover:shadow-xl transform hover:-translate-y-1">

                                            <div class="text-gray-700 dark:text-gray-300 text-sm font-medium">{{ strtoupper($provider->name) }}</div>
                                            <div class="text-xl text-gray-800 dark:text-white font-semibold mt-2">

                                                <span class="text-green-500">{{$provider->totalUsage }}</span>
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
