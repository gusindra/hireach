<div class="relative overflow-x-auto">
    <div class="flex justify-between items-center mb-4">
        <div>
            <input
                type="text"
                wire:model="search"
                placeholder="Search by User Name..."
                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </div>


    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">User Name</th>
                <th scope="col" class="px-6 py-3">Content</th>
                <th scope="col" class="px-6 py-3">Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ \App\Models\User::find($item['user_id'])?->name ?? 'Unknown User' }}</td>
                    <td class="px-6 py-4">{{ $item['content'] }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($item['created_at'])->format('Y-m-d H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="flex justify-between ">
        <div>
            <select wire:model="perPage" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ($itemsPerPageOptions as $option)
                    <option value="{{ $option }}">{{ $option === 'All' ? 'All' : $option }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    </div>

</div>
