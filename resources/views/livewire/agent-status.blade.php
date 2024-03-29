<div>
    <x-jet-dropdown align="right" width="60">
        <x-slot name="trigger">
            <span class="inline-flex rounded-md absolute right-0">
                <button type="button" class="inline-flex items-center border border-transparent text-xs leading-4 font-medium rounded-md text-gray-500 dark:text-slate-300 bg-white supports-backdrop-blur:bg-white/60 dark:bg-slate-800 hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                    @if($status=='Online')
                    <div title="{{$status}}" class="bg-green-600 w-3 h-3 rounded-xl"></div>
                    @elseif($status=='Away')
                    <div title="{{$status}}" class="bg-yellow-600 w-3 h-3 rounded-xl"></div>
                    @else
                    <div title="{{$status}}" class="bg-red-600 w-3 h-3 rounded-xl"></div>
                    @endif
                </button>
            </span>
        </x-slot>

        <x-slot name="content">
            <div class="w-60">
                <!-- Team Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Status') }}
                </div>
                <x-switchable-status :selection="$selection" :status="$status"></x-switchable-status>
            </div>
        </x-slot>
    </x-jet-dropdown>
</div>
