<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin\Role;
use Illuminate\Database\Seeder;
use App\Models\Admin\Permission;
use Illuminate\Support\Facades\Hash;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //User Status
            'user_status_management',
            //Role
            'user_role_management',
            //Permission
            'user_permission_management',
            //User
            'user_browse',
            'user_show',
            'user_create',
            'user_edit',
            'user_delete',
            // Bteb Result management
            'page_builder',
            // Setting
            'setting_management',
            'report_issue_management',

            // colors
            'colors',
            // attributes sets
            'attributes_sets',
            // attributes values
            'attributes_values',
            // categories
            'categories',
            // products
            'products',
            // sliders
            'sliders',
        ];

        $role = [
            'Developer',
            'Admin',
            'Manager',
            'Team Member',
            'Contributor',
            'Author',
        ];

        $developer = Role::create(['name' => 'Developer']);
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission])->assignRole($developer);
        }

        $admin->givePermissionTo([
            'page_builder',
            'setting_management',
            'report_issue_management',

            'colors',
            'attributes_sets',
            'attributes_values',
            'categories',
            'products',
            'sliders',
        ]);
        $user->givePermissionTo([]);


        $users = [
            [
                'name' => 'Developer Account',
                'username' => 'developer',
                'email' => 'rabiulhassandev@gmail.com',
                'phone' => '01601308010',
                'password' => Hash::make('developer'),
                'email_verified_at' => now(),
                'user_status_id' => 2,
                'role' => 'Developer',
                'permissions' => [],
            ],
            [
                'name' => 'Admin Account',
                'username' => 'admin',
                'email' => 'admin@domain.com',
                'phone' => '01842301011',
                'password' => Hash::make('12345'),
                'role' => 'Admin',
                'permissions' => [],
            ],
            // [
            //     'name' => 'User Account',
            //     'username' => 'user',
            //     'email' => 'user@domain.com',
            //     'phone' => '01842301012',
            //     'password' => Hash::make('12345'),
            //     'role' => 'User',
            //     'permissions' => [],
            // ],
        ];
        foreach ($users as  $user) {
            User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'password' => $user['password'],
                'user_status_id' => 2,
            ])->assignRole($user['role'])->syncPermissions($user['permissions']);
        }

    }
}
