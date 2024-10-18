<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Order Reports</h2>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date:</label>
            <input type="date" id="startDate" wire:model="startDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" />
        </div>
        <div>
            <label for="endDate" class="block text-sm font-medium text-gray-700">End Date:</label>
            <input type="date" id="endDate" wire:model="endDate" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" />
        </div>
    </div>

    <div class="mb-4">
        <button wire:click="applyFilter" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Filter
        </button>
        <button wire:click="clearFilter" class="inline-flex items-center px-4 py-2 ml-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Clear Filter
        </button>
    </div>

    <livewire:table.order-reports-table
    :startDate="$startDate"
    :endDate="$endDate"
    :exportable="true" />

</div>
