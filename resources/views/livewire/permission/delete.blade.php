<div>
    <button wire:click="deletePermission({{ $id }})"
        onclick="return confirm('Are you sure you want to delete?')" class="text-red-500 font-bold py-2 px-4 rounded">
        Delete
    </button>
</div>
