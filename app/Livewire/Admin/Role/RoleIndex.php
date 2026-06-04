<?php

namespace App\Livewire\Admin\Role;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public function render()
    {
        return view('livewire.admin.role.role-index', [
            'roles' => Role::with('permissions')->paginate($this->perPage),
        ]);
    }
}
