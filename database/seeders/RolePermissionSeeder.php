<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::firstOrCreate(['name' => 'administrador']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin753'),
            ]
        );
        $admin->syncRoles(['administrador']);
        $this->command->info("✓ Usuario admin: {$admin->email} / Admin753");

        $rodolfo = User::firstOrCreate(
            ['email' => 'riveros70397516@gmail.com'],
            [
                'name' => 'Rodolfo Riveros Mitma',
                'password' => Hash::make('12345678'),
            ]
        );
        $rodolfo->syncRoles(['administrador']);
        $this->command->info("✓ Usuario: {$rodolfo->email} / 12345678");

        $this->command->info('Seeder ejecutado correctamente.');
    }
}
