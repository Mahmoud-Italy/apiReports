<?php
use App\Legacy\Routes;
$app = new Routes($router);

$router->get('/', function () use ($router) {
    return $router->app->version();
});

# API v1 created at November, 2020
$router->group(['prefix' => 'v1'], function($router) use ($app) {


    /** Backend **/
    $router->group(['prefix' => 'dashboard', 'namespace' => 'Backend'], function($router) use ($app) {
        $app->authResource('auth', 'AuthController');
        $router->group(['middleware' => 'auth'], function($router) use ($app) {
            $app->exploreResource('explore', 'ExploreController');
            $app->apiResource('applications', 'ApplicationController');
            $app->artisanResource('caches', 'CacheController');
            $app->apiResource('inbox', 'InboxController');
            $app->apiResource('ipblockers', 'IpblockerController');
            $app->apiResource('media', 'MediaController');
            $app->apiResource('pages', 'PageController');
            $app->apiResource('permissions', 'PermissionController');
            $app->apiResource('roles', 'RoleController');
            $app->apiResource('settings', 'SettingController');
            $app->apiResource('socials', 'SocialController');
            $app->apiResource('users', 'UserController');
        });
    });


    /** Frontend **/
    $router->group(['namespace' => 'Frontend'], function($router) use ($app) {
        $app->frontResource('pages', 'PageController');
        $app->frontResource('contacts', 'ContactController');
        $app->frontResource('socials', 'SocialController');
        $app->frontResource('settings', 'SettingController');
        $router->get('sitemap.xml', 'SitemapController');
    });

});


