<div>
    <div class="w-full">
        <div class="container p-4 mx-auto">
            @if (session()->has('message'))
            <div class="flex items-center px-4 py-3 mb-6 text-sm font-bold text-white bg-green-500 rounded" role="alert">
                <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
                </svg>
                <p>{{ session('message') }}</p>
            </div>
            @endif

            <div class="flex flex-wrap1 -mx-2">
                @foreach($photos as $photo)
                <div class="w-full p-2">
                    <div class="w-auto border dark:border-0">
                        <img class="w-auto mt-4 rounded-xl shadow-soft-3xl max-h-32" src="https://telixcel.s3.ap-southeast-1.amazonaws.com/{{ $photo->file }}">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mb-6 pb-6">
                <form wire:submit.prevent="save">
                    <div class="mb-3">
                        <input type="file" wire:model="photo" class="">
                        <div>
                            @error('photo') <span class="text-sm italic text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div wire:loading wire:target="photo" class="text-sm italic text-gray-500">Uploading...</div>
                    </div>

                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Upload Image</button>
                </form>
            </div>
        </div>
    </div>
</div>
