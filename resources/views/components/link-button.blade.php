<div>
    <button x-show="value"
        {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border p-2 text-black border-transparent rounded-md font-semibold text-xs tracking-widest hover:text-green-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition']) }}>
        {{ $slot }}
    </button>
</div>
