<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'ver dashboard',
            'ver estudiantes', 'crear estudiantes', 'editar estudiantes', 'eliminar estudiantes',
            'ver libros', 'crear libros', 'editar libros', 'eliminar libros',
            'ver prestamos', 'crear prestamos', 'editar prestamos', 'devolver prestamos',
            'ver categorias', 'crear categorias', 'editar categorias', 'eliminar categorias',
            'ver instituciones', 'crear instituciones', 'editar instituciones', 'eliminar instituciones',
            'ver programas', 'crear programas', 'editar programas', 'eliminar programas',
            'ver usuarios', 'crear usuarios', 'editar usuarios', 'eliminar usuarios',
            'ver roles', 'crear roles', 'editar roles', 'eliminar roles',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        Role::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'bibliotecario', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'lector', 'guard_name' => 'web']);

        Role::where('name', 'administrador')->first()->syncPermissions(Permission::all());

        Role::where('name', 'bibliotecario')->first()->syncPermissions([
            'ver dashboard',
            'ver estudiantes', 'crear estudiantes', 'editar estudiantes',
            'ver libros', 'crear libros', 'editar libros',
            'ver prestamos', 'crear prestamos', 'editar prestamos', 'devolver prestamos',
            'ver categorias', 'crear categorias', 'editar categorias',
            'ver instituciones',
            'ver programas',
        ]);

        Role::where('name', 'lector')->first()->syncPermissions([
            'ver dashboard',
            'ver libros',
            'ver prestamos',
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Admin753'),
                'email_verified_at' => now(),
            ]
        );
        $admin->syncRoles(['administrador']);
        $this->command->info('✓ admin@gmail.com / Admin753 (administrador)');

        $rodolfo = User::firstOrCreate(
            ['email' => 'riveros70397516@gmail.com'],
            [
                'name' => 'Rodolfo Riveros Mitma',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );
        $rodolfo->syncRoles(['administrador']);
        $this->command->info('✓ riveros70397516@gmail.com / 12345678 (administrador)');

        $this->command->info('✓ '.Permission::count().' permisos, '.Role::count().' roles creados.');
    }
}
