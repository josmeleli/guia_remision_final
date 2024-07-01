<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UsersIndex extends Component
{

    use WithPagination;

    public $search;

    protected $paginationTheme = "bootstrap";
    public function render()
    {
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->where('id', '!=', 1)
            ->paginate();
        return view('livewire.admin.users-index', compact('users'));
    }
}
