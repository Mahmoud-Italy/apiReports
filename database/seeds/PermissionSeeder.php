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
        $this->handle('users',        ['view', 'add', 'edit', 'delete']);
        $this->handle('roles',        ['view', 'add', 'edit', 'delete']);
        $this->handle('blogs',        ['view', 'add', 'edit', 'delete']);
        $this->handle('destinations', ['view', 'add', 'edit', 'delete']);
        $this->handle('sliders',      ['view', 'add', 'edit', 'delete']);
        $this->handle('faqs',         ['view', 'add', 'edit', 'delete']);
        $this->handle('reviews',      ['view', 'add', 'edit', 'delete']);
        $this->handle('socials',      ['view', 'add', 'edit', 'delete']);
        $this->handle('hotels',       ['view', 'add', 'edit', 'delete']);
        $this->handle('wikis',        ['view', 'add', 'edit', 'delete']);
        $this->handle('packages',     ['view', 'add', 'edit', 'delete']);
        $this->handle('settings',     ['view', 'add', 'edit', 'delete']);
        $this->handle('categories',   ['view', 'add', 'edit', 'delete']);
        $this->handle('pages',        ['view', 'add', 'edit', 'delete']);
        $this->handle('cruises',      ['view', 'add', 'edit', 'delete']);
        $this->handle('tags',         ['view', 'add', 'edit', 'delete']);
    }

    public function handle($table, $fields)
    {
        foreach($fields as $field) {
          $array[] = ['name' => $field.'_'.$table, 'guard_name' => 'api'];
        }
        Permission::insert($array);
    }
}
