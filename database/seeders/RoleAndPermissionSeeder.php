<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Events
            'view events',
            'create events',
            'update events',
            'delete events',

            // Reservations
            'view reservations',
            'create reservations',
            'delete reservations',

            // Event Types
            'view event types',
            'create event types',
            'update event types',
            'delete event types',

            // Locations
            'view locations',
            'create locations',
            'update locations',
            'delete locations',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $organizerRole = Role::firstOrCreate(['name' => 'organizer']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());

        $organizerRole->givePermissionTo([
            'view events',
            'create events',
            'update events',
            'delete events',
            'view reservations',
            'create reservations',
            'delete reservations',
        ]);

        $userRole->givePermissionTo([
            'view events',
            'create reservations',
            'view reservations',
        ]);

        // Create users and assign roles
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        $organizer = User::firstOrCreate([
            'email' => 'organizer@example.com',
        ], [
            'name' => 'Organizer User',
            'password' => Hash::make('password'),
        ]);
        $organizer->assignRole($organizerRole);

        $user = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'Regular User',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole($userRole);
    }
}