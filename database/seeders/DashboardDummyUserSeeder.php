<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DashboardDummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Ensure the Dashboard permissions are seeded first
        $this->call(DashboardPermissionDatabaseSeeder::class);

        // 2. Fetch or create a default department
        $department = Department::first();
        if (!$department) {
            $department = Department::factory()->create();
        }

        // 3. Create/update the dummy user
        $user = User::updateOrCreate(
            ['email' => 'admin_dashboard@aims.test'],
            [
                'name' => 'Admin Dashboard Dummy',
                'password' => Hash::make('password'),
                'department_id' => $department->id,
            ]
        );

        // 4. Create/update the Spatie role for the 'dashboard' guard
        $role = Role::updateOrCreate(
            [
                'name' => 'Admin Dashboard',
                'guard_name' => 'dashboard'
            ]
        );

        // 5. Retrieve all dashboard permissions and sync them to the role
        $permissions = Permission::where('guard_name', 'dashboard')->get();
        $role->syncPermissions($permissions);

        // 6. Assign the role to the dummy user
        // Using Spatie's assignRole method. Since the role is for 'dashboard' guard,
        // it assigns correctly in user_has_roles/model_has_roles.
        $user->assignRole($role);

        $this->command->info('Dummy user admin_dashboard@aims.test created successfully with password "password" and Admin Dashboard role.');
    }
}
