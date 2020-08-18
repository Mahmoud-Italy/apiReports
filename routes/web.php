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
        $app->authResource('auth', 'AuthController');
        
        $app->exploreResource('explore', 'ExploreController');
        $app->apiResource('home', 'SettingController');
        $app->apiResource('accreditations', 'AccreditationController');
        $app->apiResource('programs', 'ProgramController');
        $app->apiResource('sectors', 'SectorController');
        $app->apiResource('products', 'ProductController');
        $app->apiResource('memberships', 'MembershipController');
        $app->apiResource('about', 'SettingController');
        $app->apiResource('contacts', 'SettingController');
        $app->apiResource('inbox', 'InboxController');
        $app->apiResource('media', 'MediaController');
        $app->apiResource('trainings', 'TrainingController');
        $app->apiResource('members', 'MemberController');
        $app->apiResource('users', 'UserController');
        $app->apiResource('faqs', 'FaqController');
        $app->apiResource('searchs', 'SearchController');
        $app->apiResource('privacy', 'PrivacyController');
        $app->apiResource('events', 'SettingController');
        $app->apiResource('online', 'OnlineController');
        $app->apiResource('socials', 'SocialController');
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


