<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = [
            [
                'label' => 'Administrator',
                'name'  => 'administrator'
            ],
            [
                'label' => 'Blogger',
                'name'  => 'blogger'
            ],
            [
                'label' => 'Advertiser',
                'name'  => 'advertiser'
            ]
        ];

        foreach ($roles as $role) {
            App\Role::create($role);
        }

        $adminRole = App\Role::getRole('administrator');

        $permissions = [
            [
                'label' => 'Edit User',
                'name'  => 'edit_user'
            ],
            [
                'label' => 'Create User',
                'name'  => 'create_user'
            ],
            [
                'label' => 'View User',
                'name'  => 'view_user'
            ],
            [
                'label' => 'Delete User',
                'name'  => 'delete_user'
            ],
        ];

        foreach ($permissions as $permission) {
            $adminRole->givePermissionTo(App\Permission::create($permission));
        }
        
        (new App\User)->createUser(env('ADMIN_EMAIL'), env('ADMIN_PASSWORD'), $adminRole);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
