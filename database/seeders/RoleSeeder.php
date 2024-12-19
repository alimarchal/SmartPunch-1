<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\SuperAdmin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Log;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            // Web guard roles
            $webRoles = [
                'admin',
                'hr',
                'guest',
                'ibr',
                'manager',
                'supervisor',
                'employee',
            ];

            foreach ($webRoles as $role) {
                Role::firstOrCreate(
                    ['name' => $role],
                    ['guard_name' => 'web']
                );
            }

            // Create super admin role if it doesn't exist
            $superAdminRole = Role::firstOrCreate(
                ['name' => 'super_admin'],
                ['guard_name' => 'super_admin']
            );

            // Create super admin user if it doesn't exist
            $superAdmin = SuperAdmin::firstOrCreate(
                ['email' => 'admin@smartpunch.app'],
                [
                    'name' => 'SmartPunch',
                    'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', '123456789')),
                    'role' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );

            // Get all super admin permissions
            $superAdminPermissions = Permission::where('guard_name', 'super_admin')->get();

            if ($superAdminPermissions->isEmpty()) {
                Log::warning('No super admin permissions found. Make sure to run PermissionSeeder first.');
            }

            // Sync permissions to super admin role
            $superAdminRole->syncPermissions($superAdminPermissions);

            // Assign super admin role to user
            if (!$superAdmin->hasRole('super_admin')) {
                $superAdmin->assignRole($superAdminRole);
            }

            Log::info('RoleSeeder completed successfully');

        } catch (\Exception $e) {
            Log::error('Error in RoleSeeder: ' . $e->getMessage());
            throw $e;
        }
    }
}
