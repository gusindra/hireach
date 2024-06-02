<div>
    <div class="flex items-center text-right">
        <a class="cursor-pointer text-sm text-gray-400 dark:text-slate-300 underline" wire:click="actionShowModal">
            {{ __('Embed Script Live Chat to Website') }}
        </a>
    </div>

    <!-- Script Value Modal -->
    <x-jet-dialog-modal wire:model="modalActionVisible">
        <x-slot name="title">
            {{ __('Embed Script') }}
        </x-slot>

        <x-slot name="content">
        <textarea class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full h-64"
                autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" readonly="true"><!--Start of Website Chat Script-->
    <div style="position: fixed;bottom: 0;padding: 10px;z-index: 99;text-align: right;"><div id="frame" data-id="{{$dataId}}" style="position: fixed;bottom: -15px;width: auto;right: 10px;"></div></div>
    <script src="https://telixcel.s3.ap-southeast-1.amazonaws.com/assets/telixcel-chat.min.js" type="text/javascript"></script>
<!--End of Website Chat Script--></textarea>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalActionVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
