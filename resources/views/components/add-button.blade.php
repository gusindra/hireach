<div>
    <button x-show="value"
        {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border p-2 text-black dark:text-white border-transparent rounded-md font-semibold text-xs tracking-widest hover:text-green-400 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition']) }}>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3 h-3 mb-1 mr-1">
        <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
        </svg>
        {{ $slot }}
    </button>
</div>
