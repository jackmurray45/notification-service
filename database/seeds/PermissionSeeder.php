<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionData = [];

        /**
         * Generic permissions per each model
         */
        foreach(['Notifications', 'Roles', 'Tokens'] as $modelName)
        {
            $permissionData = array_merge($permissionData, [
                ['name' => "Read $modelName", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => "Create $modelName", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => "Update $modelName", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => "Delete $modelName", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ]);
        }

        /**
         * Permissions specific to each model...
         */


        /**
         * Token specific permissions
         */
        $permissionData[] = ['name' => "Regenerate Tokens", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        Permission::insert($permissionData);
    }
}
