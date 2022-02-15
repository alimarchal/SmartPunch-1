<?php

use App\Models\SuperAdmin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateSuperAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role');
            $table->tinyInteger('active')->default(1);      /* 0 for inactive and 1 for active */
            $table->timestamps();
        });

        $superAdminRole = Role::with('permissions')->where('name', 'super admin')->first();
        $permission = Permission::where('name', 'suspend business')->first();;

        SuperAdmin::create([
            'name' => 'SmartPunch',
            'email' => 'admin@smartpunch.app',
            'password' => \Illuminate\Support\Facades\Hash::make(123456789),
            'role' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ])->assignRole($superAdminRole)->syncPermissions($permission);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('super_admins');
    }
}
