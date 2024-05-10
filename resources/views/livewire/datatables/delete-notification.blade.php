<div>
    <button wire:click="deleteNotification({{ $id }})"
        onclick="return confirm('Are you sure you want to delete?')" {{ $disabled }}
        class="text-red-500 font-bold py-2 px-4 rounded">
        Delete
    </button>
</div>
