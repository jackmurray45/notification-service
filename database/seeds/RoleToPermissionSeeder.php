<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleToPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelNames = ['Notifications', 'Roles', 'Tokens'];
        $roleToPermissionNames = [
            "Full Access" => ["Read", "Create", "Update", "Delete"], 
            "Creater" => ["Read", "Create"], 
            "Reader" =>  ["Read"]
        ];

        foreach($modelNames as $modelName){
            foreach($roleToPermissionNames as $roleName => $permissionNames)
            {
                $role = Role::where('name', "$modelName $roleName")->first();
                foreach($permissionNames as $permissionName)
                {
                    $permission = Permission::where('name', "$permissionName $modelName")->first();
                    $role->givePermissionTo($permission);
                }                
            }
        }

        /**
         * Attach specific permissions to roles
         */
        $role = Role::where('name', "Tokens Full Access")->first();
        $permission = Permission::where('name', "Token Regenerate")->first();
        $role->givePermissionTo($permission);

    }
}
