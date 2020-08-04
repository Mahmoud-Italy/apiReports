<?php

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
        $rows = Permission::get();
        foreach ($rows as $row) {
           $array[] = ['permission_id' => $row->id, 'role_id' => 2];
        }
        \DB::table('role_has_permissions')->insert($array);
    }
}
