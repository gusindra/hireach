<x-app-layout>

    <div class="container mx-auto py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Contact List</h2>


                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse">
                        <thead>

                            <tr class="bg-gray-100">
                                <th class="px-4 py-2"><a href=""></a>UUID</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Phone</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($client as $item)
                            <tr>
                                <td class="border text-yellow-500 px-4 py-2">
                                    @if ($item->uuid)
                                        <a href="{{ route('contacts.edit', ['uuid' => $item->uuid]) }}">{{ $item->uuid }}</a>
                                    @else
                                        {{ $item->uuid }}
                                    @endif
                                </td>
                                <td class="border px-4 py-2">{{ $item->title }}</td>
                                <td class="border px-4 py-2">{{ $item->name }}</td>
                                <td class="border px-4 py-2">{{ $item->email }}</td>
                                <td class="border px-4 py-2">{{ $item->phone }}</td>
                            </tr>


                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




</x-app-layout>
