<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->handle('caches',         ['view']);
        $this->handle('inbox',          ['view', 'show', 'delete']);
        $this->handle('users',          ['view', 'add', 'edit', 'delete']);
        $this->handle('roles',          ['view', 'add', 'edit', 'delete']);
        $this->handle('socials',        ['view', 'add', 'edit', 'delete']);
        $this->handle('media',          ['view', 'add', 'edit', 'delete']);
        $this->handle('settings',       ['view', 'add', 'edit', 'delete']);
        $this->handle('pages',          ['view', 'add', 'edit', 'delete']);
        $this->handle('ipblockers',     ['view', 'add', 'edit', 'delete']);
    }

    public function handle($table, $fields)
    {
        foreach($fields as $field) {
          $array[] = ['name' => $field.'_'.$table, 'guard_name' => 'api'];
        }
        Permission::insert($array);
    }
}
