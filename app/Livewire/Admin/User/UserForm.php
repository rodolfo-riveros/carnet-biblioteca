<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserForm extends Component
{
    public ?int $userId = null;

    public bool $isEditMode = false;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?string $role = null;

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'.($this->userId ? ",{$this->userId}" : '')],
            'role' => ['required', 'exists:roles,name'],
        ];

        if (! $this->isEditMode) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
            $rules['password_confirmation'] = ['required'];
        }

        return $rules;
    }

    protected array $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.min' => 'El nombre debe tener al menos 3 caracteres.',
        'email.required' => 'El email es obligatorio.',
        'email.email' => 'Ingrese un email válido.',
        'email.unique' => 'Ya existe un usuario con ese email.',
        'role.required' => 'Debe seleccionar un rol.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ];

    public function mount(?int $id = null): void
    {
        if ($id) {
            $user = User::with('roles')->findOrFail($id);
            $this->userId = $id;
            $this->isEditMode = true;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->roles->first()?->name;
        }
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->isEditMode) {
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);
            if (! empty($this->password)) {
                $user->update(['password' => Hash::make($this->password)]);
            }
            $user->syncRoles([$data['role']]);
            Flux::toast(text: 'Usuario actualizado correctamente.', variant: 'success');
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->assignRole($data['role']);
            Flux::toast(text: 'Usuario registrado correctamente.', variant: 'success');
            $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
        }

        $this->dispatch('usuario-guardado');
        $this->redirectRoute('usuarios.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.user.user-form', [
            'roles' => Role::all(),
        ]);
    }
}
