<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    $guard_name = 'api';
      return [ 
          'name'       => 'view_destinations',
          'guard_name' => $guard_name
      ];
});

