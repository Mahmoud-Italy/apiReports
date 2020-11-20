<?php

use Carbon\Carbon;
use App\Models\App;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->handel('Inbox', 'ti-email');
        $this->handel('Media', 'ti-cloud-up');
        $this->handel('Pages', 'ti-files');
        $this->handel('Settings', 'ti-settings');
        $this->handel('Socials', 'ti-twitter');
        $this->handel('Users', 'ti-user');
        $this->handel('IP Blockers', 'ti-lock');
        $this->handel('Roles', 'ti-key');
        $this->handel('Caches', 'ti-wand');
        // add more applications
    }


    public function handel($name, $icon)
    {
        $insert = ['name'       => $name, 
                   'icon'       => $icon, 
                   'status'     => true, 
                   'created_at' => Carbon::now(), 
                   'updated_At' => Carbon::now()
                ];
        App::insert($insert);
    }
}
