<div class="min-h-screen flex flex-col sm:justify-center items-center lg:pt-6 md:pt-0 bg-gray-100 dark:bg-slate-800 space-y-3">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full lg:w-1/3 max-w-2xl sm:max-w-md m-2 md:mt-0 p-0 bg-white dark:bg-slate-700 shadow-md overflow-hidden sm:rounded-lg p-6">
        {{ $slot }}
    </div>
</div>
