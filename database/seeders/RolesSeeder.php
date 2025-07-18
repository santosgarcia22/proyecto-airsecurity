<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
    $roleAdmin = Role::firstOrCreate(['name' => 'admin']);

    // Usuario
    $roleUsuario = Role::firstOrCreate(['name' => 'usuario']);

    // Permisos
    $permisoRoles = Permission::firstOrCreate([
        'name' => 'sidebar.roles.y.permisos'
    ], [
        'description' => 'sidebar seccion roles y permisos'
    ]);

    $permisoDashboard = Permission::firstOrCreate([
        'name' => 'sidebar.dashboard'
    ], [
        'description' => 'sidebar dashboard'
    ]);

    $permisoRoles->syncRoles([$roleAdmin]);
    $permisoDashboard->syncRoles([$roleUsuario]);

    }
}
