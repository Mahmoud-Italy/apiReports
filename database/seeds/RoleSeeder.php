<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
                'name'       => 'root',
                'guard_name' => 'api',
            ]);

        $rows = Permission::get();
        foreach ($rows as $row) {
           $array[] = ['permission_id' => $row->id, 'role_id' => $role->id];
        }
        \DB::table('role_has_permissions')->insert($array);
    }
}
