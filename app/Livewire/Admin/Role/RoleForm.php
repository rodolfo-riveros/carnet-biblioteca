<?php

namespace App\Livewire\Admin\Role;

use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleForm extends Component
{
    public ?int $roleId = null;

    public bool $isEditMode = false;

    public string $name = '';

    public array $selectedPermissions = [];

    public function mount(?int $id = null): void
    {
        $this->selectedPermissions = Permission::pluck('name')->toArray();

        if ($id) {
            $role = Role::with('permissions')->findOrFail($id);
            $this->roleId = $id;
            $this->isEditMode = true;
            $this->name = $role->name;
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        }
    }

    public function toggleAll(bool $value): void
    {
        $this->selectedPermissions = $value ? Permission::pluck('name')->toArray() : [];
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:roles,name'.($this->roleId ? ",{$this->roleId}" : '')],
        ]);

        if ($this->isEditMode) {
            $role = Role::findOrFail($this->roleId);
            $role->update(['name' => Str::slug($this->name)]);
        } else {
            $role = Role::create(['name' => Str::slug($this->name)]);
        }

        $role->syncPermissions($this->selectedPermissions);

        Flux::toast(text: 'Rol '.($this->isEditMode ? 'actualizado' : 'creado').' correctamente.', variant: 'success');

        $this->redirectRoute('roles.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.role.role-form', [
            'permissionsGrouped' => Permission::all()->groupBy(function ($p) {
                return explode(' ', $p->name)[1] ?? 'general';
            }),
        ]);
    }
}
