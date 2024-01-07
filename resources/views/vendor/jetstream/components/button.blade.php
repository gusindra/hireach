<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center border bg-slate-700 px-4 py-2 border rounded-md font-semibold text-xs text-slate-200 dark:text-slate-300 uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition']) }}
>
        {{ $slot }}
</button>
