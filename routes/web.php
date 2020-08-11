<?php
use Lararoutes\Lumen\CustomRoutes;
$app = new CustomRoutes($router);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


# API v1 created at August, 2020
$router->group(['prefix' => 'api/v1'], function($router) use ($app) {


  /** Backend **/
  $router->group(['prefix' => 'dashboard', 'namespace' => 'Backend'], function($router) use ($app) {

    # Auth
    $app->authResource('auth', 'AuthController');
    
    # Navigation
    //$app->apiResource('/', 'AppController');
    $app->apiResource('articles', 'ArticleController');
    $app->apiResource('categories', 'CategoryController');
    $app->apiResource('cruises', 'CruiseController');
    $app->apiResource('destinations', 'DestinationController');
    $app->apiResource('medias', 'MediaController');
    $app->apiResource('logs', 'LogController');
    $app->apiResource('packageTypes', 'PackageTypeController');
    $app->apiResource('packages', 'PackageController');
    $app->apiResource('pages', 'PageController');
    $app->apiResource('tags', 'TagController');
    $app->apiResource('users', 'UserController');
    $app->apiResource('wikis', 'WikiController');
    $app->apiResource('writers', 'WriterController');
    //$app->apiResource('appsettings', 'AppSettingController');
    $app->apiResource('apps', 'AppController');
    

        # App Settings
        $app->apiResource('accommodations', 'AccommodationController');
        $app->apiResource('faqs', 'FaqWriterController');
        $app->apiResource('hotels', 'HotelController');
        $app->apiResource('roles', 'RoleController');
        $app->apiResource('regions', 'RegionController');
        $app->apiResource('reviews', 'ReviewController');
        $app->apiResource('sliders', 'SliderController');
        $app->apiResource('socials', 'SocialController');
        $app->apiResource('tenants', 'TenantController');
        $app->apiResource('updates', 'UpdateController');
    
    });







    /** Frontend **/
    $router->group(['namespace' => 'Frontend'], function($router) use ($app) {

        # Auth
        $app->authResource('auth', 'AuthController');

        # Cache Clear
        $router->get('cache/clear', function(){
            Cache::flush();
        });

    });

});


