<div>
    <a wire:click="deleteNotification({{ $id }})" onclick="return confirm('Are you sure you want to delete?')"
        {{ $disabled }}
        class="cursor-pointer text-xs dark:text-slate-400 hover:border-red-500 hover:bg-red-50 hover:shadow-sm text-red-600 rounded-lg px-3 py-1">
        Delete
    </a>
</div>
