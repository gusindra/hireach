<x-app-layout>

    <div class="container mx-auto py-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Add Contact</h2>


                <form action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf



                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700"></label>
                        <input type="file" name="file" id="file" autocomplete="given-name"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>


                    <div class="mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
