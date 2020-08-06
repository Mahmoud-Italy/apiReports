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
    $app->apiResource('destinations', 'DestinationController');
    $app->apiResource('categories', 'CategoryController');
    $app->apiResource('writers', 'BlogWriterController');
    $app->apiResource('articles', 'BlogArticleController');
    $app->apiResource('packageTypes', 'PackageTypeController');
    $app->apiResource('packages', 'PackageController');
    $app->apiResource('medias', 'MediaController');
    $app->apiResource('cruises', 'CruiseController');
    $app->apiResource('wikis', 'WikiController');
    $app->apiResource('users', 'UserController');
    $app->apiResource('roles', 'RoleController');
    $app->apiResource('pages', 'PageController');
    $app->apiResource('hotels', 'HotelController');

    # Settings
    $app->apiResource('regions', 'RegionController');
    $app->apiResource('updates', 'UpdateController');
    $app->apiResource('faqs', 'FaqWriterController');
    $app->apiResource('sliders', 'SliderController');
    $app->apiResource('socials', 'SocialController');
    $app->apiResource('tenants', 'TenantController');
    $app->apiResource('reviews', 'ReviewController');

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


