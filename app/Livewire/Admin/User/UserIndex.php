<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filtroRol = '';

    public int $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFiltroRol(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    protected function getUsers()
    {
        $query = User::with('roles');

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        if ($this->filtroRol !== '') {
            $query->role($this->filtroRol);
        }

        return $query->latest()->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.user.user-index', [
            'users' => $this->getUsers(),
            'roles' => Role::all(),
        ]);
    }
}
