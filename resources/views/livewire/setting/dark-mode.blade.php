<x-jet-form-section submit="updateChatTeam">
    <x-slot name="title">
        {{ __('System Display') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The display system mode.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Team Chat Slug -->
        <div class="col-span-6 sm:col-span-5">
            <x-jet-label for="slug" value="{{ __('Dark Mode') }}" />
            <div >
                <div class="mt-1 flex rounded-md shadow-sm">
                    <select
                        x-cloak
                        name="mode"
                        id="mode"
                        x-on:change="darkMode = $event.target.options[$event.target.selectedIndex].index;"
                        class="border-gray-300 dark:bg-slate-800 dark:text-slate-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full"
                        wire:model.debunce.800ms="mode"
                    >
                        <option value="false">Light</option>
                        <option value="true">Dark</option>
                    </select>
                    <x-jet-input-error for="mode" class="mt-2" />
                </div>
            </div>
            <x-jet-input-error for="name" class="mt-2" />
        </div>
    </x-slot>
    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>
    </x-slot>
</x-jet-form-section>
