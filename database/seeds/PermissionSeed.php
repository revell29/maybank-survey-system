<?php

use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('set foreign_key_checks=0;');
        // DB::table('permissions')->truncate();
        $permissions = [
            [
                'name' => 'access_user',
                'display_name' => 'Access  User'
            ],
            [
                'name' => 'create_user',
                'display_name' => 'Create User',
            ],
            [
                'name' => 'edit_user',
                'display_name' => 'Edit User',
            ],
            [
                'name' => 'delete_user',
                'display_name' => 'Delete User',
            ],
            [
                'name' => 'access_role',
                'display_name' => 'Access Role',
            ],
            [
                'name' => 'create_role',
                'display_name' => 'Create Role',
            ],
            [
                'name' => 'edit_role',
                'display_name' => 'Edit Role',
            ],
            [
                'name' => 'delete_role',
                'display_name' => 'Delete Role',
            ],
            [
                'name' => 'access_branch',
                'display_name' => 'Acess Branch',
            ],
            [
                'name' => 'create_branch',
                'display_name' => 'Create branch',
            ],
            [
                'name' => 'edit_branch',
                'display_name' => 'Edit Branch',
            ],
            [
                'name' => 'delete_branch',
                'display_name' => 'Delete Branch',
            ],
            [
                'name' => 'access_user_branch',
                'display_name' => 'Access User Branch',
            ],
            [
                'name' => 'create_user_branch',
                'display_name' => 'Create User Branch',
            ],
            [
                'name' => 'edit_user_branch',
                'display_name' => 'Edit User Branch',
            ],
            [
                'name' => 'delete_user_branch',
                'display_name' => 'Delete User Branch',
            ],
            [
                'name' => 'access_report',
                'display_name' => 'Access Report',
            ],
            [
                'name' => 'export_excel',
                'display_name' => 'Export Excel',
            ],
            [
                'name' => 'export_pdf',
                'display_name' => 'Export PDF',
            ],
            [
                'name' => 'access_log',
                'display_name' => 'Access Log',
            ],
            [
                'name' => 'access_cs',
                'display_name' => 'Access Customer Service'
            ],
            [
                'name' => 'create_cs',
                'display_name' => 'Create Customer Service'
            ],
            [
                'name' => 'edit_cs',
                'display_name' => 'Edit Customer Service'
            ],
            [
                'name' => 'delete_cs',
                'display_name' => 'Delete Customer Service'
            ]
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::updateOrCreate(['name' => $permission['name']], [
                'name' => $permission['name'],
                'display_name' => $permission['display_name']
            ]);
        }

        \App\Models\Role::updateOrCreate(['name' => 'administrator'], ['name' => 'administrator', 'display_name' => 'Administrator', 'description' => '']);
        \App\Models\User::updateOrCreate(['username' => 'administrator'], ['user_id' => 'USR1', 'username' => 'administrator', 'name' => 'super_admin', 'password' => bcrypt('administrator')]);

        $role = \App\Models\Role::whereName('administrator')->first();
        $perm = \App\Models\Permission::all()->pluck('id');
        $role->perms()->sync($perm);

        $data1 = \App\Models\User::where('username', 'administrator')->first();
        // $data1->roles()->attach('1');    

        // DB::statement('set foreign_key_checks=1;');
    }
}
