<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [
            'view business',
            'create office',
            'view office',
            'update employee',
            'view employee',
            'view schedule',
            'create schedule',
            'update schedule',
            'view reports',
            'suspend business',
            'create employee',
            'view reports by office',
            'view reports by employee business ID',
            'view reports by my team',
            'delete office',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
