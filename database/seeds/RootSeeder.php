<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class RootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create default admin
        $row = new User;
        $row->tenant_id = NULL;
        $row->name = 'Super admin';
        $row->email = 'admin@site.com';
            $plainPassword  = 'root';
            $row->password  = app('hash')->make($plainPassword);
        $row->active = true;
        $row->status = true;
        $row->save();

        $row->assignRole('root'); // assign root role
    }
}
