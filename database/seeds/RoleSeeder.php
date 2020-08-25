<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleData = [];
        foreach(['Notifications', 'Roles', 'Tokens'] as $modelName)
        {
            $roleData = array_merge($roleData, [
                ['name' => "$modelName Full Access", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => "$modelName Creater", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => "$modelName Reader", 'guard_name' => 'api', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ]);
        }

        Role::insert($roleData);
    }
}
