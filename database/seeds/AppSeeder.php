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
        $this->handel('Accommodations', 'ti-home');
        $this->handel('Articles', 'ti-pencil-alt');
        $this->handel('Categories', 'ti-harddrives');
        $this->handel('Caches', 'ti-wand');
        $this->handel('CruiseTypes', 'ti-signal');
        $this->handel('Cruises', 'ti-gift');
        $this->handel('Destinations', 'ti-map-alt');
        $this->handel('Hotels', 'ti-truck');
        $this->handel('PackageTypes', 'ti-signal');
        $this->handel('Packages', 'ti-package');
        $this->handel('Pages', 'ti-files');
        $this->handel('Tags', 'ti-tag');
        $this->handel('Tenants', 'ti-panel');
        $this->handel('Logs', 'ti-brush-alt');
        $this->handel('Media', 'ti-cloud-up');
        $this->handel('Users', 'ti-user');
        $this->handel('Updates', 'ti-zip');
        $this->handel('Roles', 'ti-key');
        $this->handel('Reviews', 'ti-star');
        $this->handel('Inquires', 'ti-bell');
        $this->handel('IP Blockers', 'ti-lock');
        $this->handel('Settings', 'ti-settings');
        $this->handel('Sliders', 'ti-gallery');
        $this->handel('Socials', 'ti-facebook');
        $this->handel('Wikis', 'ti-agenda');
        $this->handel('Writers', 'ti-paint-roller');
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
