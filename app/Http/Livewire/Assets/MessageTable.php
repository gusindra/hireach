<?php

namespace App\Http\Livewire\Assets;

use App\Models\BlastMessage;
use App\Models\Request as ModelRequest;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class MessageTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $itemsPerPageOptions = [10, 20, 50, 100, 'All'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $blastMessages = BlastMessage::with('user')->select('user_id', 'message_content as content', 'created_at')->get();
        $requests = ModelRequest::with('user')->select('user_id', 'reply as content', 'created_at')->get();
        $combinedData = $blastMessages->concat($requests);

        if ($this->search) {
            $combinedData = $combinedData->filter(function ($item) {
                $userName = User::find($item['user_id'])?->name;
                return stripos($userName, $this->search) !== false ||
                       stripos($item['content'], $this->search) !== false;
            });
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $this->perPage === 'All' ? $combinedData->count() : $this->perPage;
        $currentItems = $combinedData->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedData = new LengthAwarePaginator($currentItems, $combinedData->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('livewire.assets.message-table', [
            'data' => $paginatedData,
        ]);
    }
}
