<div class="p-4">
    <button x-show="value"
        {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border p-2 text-black dark:text-white dark:text-underline border-transparent rounded-md font-semibold text-xs tracking-widest hover:text-green-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition']) }}>
        {{ $slot }}
    </button>
</div>
