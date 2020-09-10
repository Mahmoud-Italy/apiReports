<?php

namespace App\Legacy;

class Routes
{
    protected $app;
      
    public function __construct($router='')
    {
      $this->app = $router;
    }
    
    function authResource($uri, $controller)
    {
      $this->app->post($uri.'/register', $controller.'@register');
      $this->app->post($uri.'/verification', $controller.'@verification');
      $this->app->post($uri.'/login', $controller.'@login');
      $this->app->post($uri.'/logout', $controller.'@logout');
      $this->app->post($uri.'/refresh', $controller.'@refresh');
      $this->app->post($uri.'/password/forget', $controller.'@forget');
      $this->app->post($uri.'/password/reset', $controller.'@reset');
      $this->app->get($uri.'/me', $controller.'@me');
    }

    function apiResource($uri, $controller)
    {
      $this->app->get($uri, $controller.'@index');
      $this->app->post($uri, $controller.'@store');
      $this->app->get($uri.'/{id}', $controller.'@show');
      $this->app->put($uri.'/{id}', $controller.'@update');
      $this->app->delete($uri.'/{id}', $controller.'@destroy');

      $this->app->post($uri.'/active/{id}', $controller.'@active');
      $this->app->post($uri.'/inactive/{id}', $controller.'@inactive');
      $this->app->post($uri.'/trash/{id}', $controller.'@trash');
      $this->app->post($uri.'/restore/{id}', $controller.'@restore');
      $this->app->post($uri.'/export', $controller.'@export');

      // feel free to add more
    }


    function exploreResource($uri, $controller)
    {
      $this->app->get($uri.'/totalVisitors', $controller.'@visitors');
      $this->app->get($uri.'/totalTrainings', $controller.'@trainings');
      $this->app->get($uri.'/totalMembers', $controller.'@members');
      $this->app->get($uri.'/totalInstructors', $controller.'@instructors');
      $this->app->get($uri.'/totalExperiences', $controller.'@experiences');
      $this->app->get($uri.'/totalUsers', $controller.'@users');
      $this->app->get($uri.'/lineChart', $controller.'@lineChart');
      $this->app->get($uri.'/pieChart', $controller.'@pieChart');
      $this->app->get($uri.'/recentPrograms', $controller.'@recentPrograms');
      $this->app->get($uri.'/topSectors', $controller.'@topSectors');
    }

    public function legacy($uri='')
    {
        $controller = 'AppController';
        if(request()->segment(0)) {
           $controller = request()->segment(0).'Controller';
        }

        $uri = '/';
        if(request()->segment(1)) {
          $uri = request()->segment(1);
        }
        
        $this->app->get($uri, $controller.'@index');
        $this->app->post($uri, $controller.'@store');
        $this->app->get($uri.'/{id}', $controller.'@show');
        $this->app->post($uri.'/{id}', $controller.'@update');
        $this->app->put($uri.'/{id}', $controller.'@update');
        $this->app->delete($uri.'/{id}', $controller.'@destroy');
    }
}
