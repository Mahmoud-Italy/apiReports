<?php

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->handel('Accomoodation', 'ti-home');
        $this->handel('Articles', 'ti-penci-alt');
        $this->handel('ActivityLogs', 'ti-brush-alt');
        $this->handel('Categories', 'ti-harddrives');
        $this->handel('Cruises', 'ti-gift');
        $this->handel('Caches', 'ti-wand');
        $this->handel('Destinations', 'ti-map-alt');
        $this->handel('PackageTypes', 'ti-signal');
        $this->handel('Packages', 'ti-package');
        $this->handel('Pages', 'ti-files');
        $this->handel('Tags', 'ti-tag');
        $this->handel('Media', 'ti-cloud-up');
        $this->handel('Users', 'ti-user');
        $this->handel('Roles', 'ti-lock');
        $this->handel('Sliders', 'ti-gallery');
        $this->handel('Socials', 'ti-facebook');
        $this->handel('Wikis', 'ti-agenda');
        $this->handel('Writers', 'ti-paint-roller');
    }


    public function handel($name, $icon)
    {
        $insert = ['name' => $name, 'icon' => $icon];
        AppSetting::insert($insert);
    }
}
