<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Client Reports</h2>

    <!-- Date Filter Inputs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                   wire:model.defer="filterData.startDate" />
        </div>

        <div>
            <label for="endDate" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="endDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                   wire:model.defer="filterData.endDate" />
        </div>
    </div>

    <!-- Filter and Clear Filter Buttons -->
    <div class="mb-4 flex space-x-4">
        <button wire:click="applyFilter" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Filter
        </button>

        <button wire:click="clearFilters" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-gray-300 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Clear Filter
        </button>
    </div>

    <!-- Pass the date filter data to the table component -->
    <livewire:table.client-reports-table
    :startDate="$filterData['startDate']"
    :endDate="$filterData['endDate']" />

</div>
