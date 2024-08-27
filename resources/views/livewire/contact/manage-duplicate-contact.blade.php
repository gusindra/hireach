<div class="p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
    @if (session()->has('message'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('message') }}
        </div>
    @endif

    @if (!empty($duplicates))
        <div class="mb-4 text-sm font-medium text-gray-600">
            Phone number: {{ $duplicates->keys()->first() }}
        </div>
    @endif

    @if ($noDuplicatesMessage)
        <div class="mb-4 text-sm font-medium text-gray-600">
            {{ $noDuplicatesMessage }}
            <a href="{{ route('admin.contact') }}"
                class="text-blue-500 hover:text-blue-700 underline ml-2 transition ease-in-out duration-150">
                Cancel
            </a>
        </div>
    @elseif (!empty($duplicates))
        <table class="w-full mb-4 text-sm text-left border-collapse">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Phone Number</th>
                    <th class="px-4 py-2 border-b">Phone Number</th>
                    <th class="px-4 py-2 border-b">KTP Number</th>
                    <th class="px-4 py-2 border-b">Status WA</th>
                    <th class="px-4 py-2 border-b">Status No</th>
                    <th class="px-4 py-2 border-b">Activation Date</th>
                    <th class="px-4 py-2 border-b">File Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($duplicates as $phoneNumber => $records)
                    @foreach ($records as $record)
                        <tr>
                            <td class="px-4 py-2 border-t">{{ $record->id }}</td>
                            <td class="px-4 py-2 border-t">{{ $record->phone_number }}</td>
                            <td class="px-4 py-2 border-t">{{ $record->phone_number }}</td>
                            <td class="px-4 py-2 border-t">{{ $record->no_ktp }}</td>
                            <td class="px-4 py-2 border-t">{{ $record->status_wa }}</td>
                            <td class="px-4 py-2 border-t">{{ $record->status_no }}</td>
                            <td class="px-4 py-2 border-t">{{ $record->activation_date }}</td>
                            <td class="px-4 py-2 border-t">{{ $record->file_name }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <div class="flex items-center justify-end">
            <x-jet-button wire:click="processDuplicates" class="ml-4">
                Process Duplicates
            </x-jet-button>
        </div>
    @endif
</div>
