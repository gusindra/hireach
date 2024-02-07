<div class="ml-20 p-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-600 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="container mx-auto">
                <div>
                    <p class="pt-4 pl-4 font-bold">Table Approval</p>
                    <livewire:table.approval user="{{auth()->user()->id}}" />
                </div>
            </div>
        </div>
    </div>
</div>
