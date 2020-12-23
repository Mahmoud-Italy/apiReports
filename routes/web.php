<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

# API v1 created at December, 2020
$router->group(['prefix' => 'v1'], function($router) {

    /** Reports **/
    $router->get('/reports', 'ReportController@index');
    $router->get('/pieChart', 'ReportController@pieChart');
    $router->get('/lineChart/{type}', 'ReportController@lineChart');
    $router->get('/barChart', 'ReportController@barChart');
});


