@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-5 md:gap-6 mt-8 sm:mt-4']) }}>
    <x-jet-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-jet-section-title>

    <div class="mt-2 md:mt-0 md:col-span-4">
        <form wire:submit.prevent="{{ $submit }}">
            <div class="{{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-4">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-0 py-3 text-right sm:px-0 sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
