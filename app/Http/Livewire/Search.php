<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
class Search extends Component
{

    public $searchTerm;
    public $users;
    use WithPagination;

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->users = User::where('id', 'LIKE', $searchTerm)
            ->orWhere('email', 'LIKE', $searchTerm)->orderBy('id')
            ->get();
        return  view('livewire.search');
    }
}
