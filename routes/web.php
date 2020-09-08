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
        $app->apiResource('abouts', 'AboutController');
        $app->apiResource('contacts', 'SettingController');
        $app->apiResource('certificates', 'CertificateController');
        $app->apiResource('cert-products', 'CProductController');
        $app->apiResource('inbox', 'InboxController');
        $app->apiResource('media', 'MediaController');
        $app->apiResource('trainings', 'TrainingController');
        $app->apiResource('members', 'MemberController');
        $app->apiResource('users', 'UserController');
        $app->apiResource('pages', 'PageController');
        $app->apiResource('faqs', 'FaqController');
        $app->apiResource('searchs', 'SearchController');
        $app->apiResource('sectors2', 'Sector2Controller');
        $app->apiResource('products2', 'Product2Controller');
        $app->apiResource('privacy', 'PrivacyController');
        $app->apiResource('events', 'EventController');
        $app->apiResource('online', 'OnlineController');
        $app->apiResource('socials', 'SocialController');
        $app->apiResource('subscribers', 'SubscriberController');
    });







    /** Frontend **/
    $router->group(['namespace' => 'Frontend'], function($router) use ($app) {
        $app->authResource('auth', 'AuthController');
        $router->get('countries', 'AppController@countries');
        $router->get('home', 'PageController@home');
        $router->get('popularSearch', 'AppController@popular');
        $router->get('popularSearch/{slug}', 'AppController@showPopular');
        // $router->get('popularSearch/search', 'AppController@search');
        // $router->post('popularSearch/certificate', 'AppController@certificate');
        $router->get('accreditations', 'AppController@accreditations');
        $router->get('accreditations/{slug}', 'AppController@showAccreditations');
        $router->get('programs', 'AppController@programs');
        $router->get('programs/{slug}', 'AppController@showPrograms');
        $router->get('programs/sectors/{slug}', 'AppController@showSectors');
        $router->get('programs/sectors/{slug}/products', 'AppController@allProducts');
        $router->get('programs/sectors/products/{slug}', 'AppController@showProducts');
        $router->get('memberships', 'AppController@memberships');
        $router->get('memberships/{slug}', 'AppController@showMemberships');
        $router->get('about', 'AppController@about');
        $router->get('about/{slug}', 'AppController@showAbout');
        $router->get('contacts', 'PageController@contacts');
        $router->post('contacts', 'PageController@doContacts');
        $router->post('trainings-applications', 'AppController@doTrainings');
        $router->post('members-applications', 'AppController@doMembers');
        $router->get('faqs', 'AppController@faqs');
        $router->get('faqs/{slug}', 'AppController@showFaqs');
        $router->get('privacy', 'AppController@privacy');
        $router->get('privacy/{slug}', 'AppController@showPrivacy');
        $router->get('events', 'PageController@events');
        $router->get('online-trainings', 'AppController@online');
        $router->get('online-trainings/{slug}', 'AppController@showOnline');
        $router->post('newsletters', 'AppController@newsletters');
        $router->get('pages', 'PageController@index');
        $router->get('pages/{slug}', 'PageController@show');
        $router->get('socials', 'AppController@socials');

        $router->get('myProfile', 'AppController@profile');
        $router->post('myProfile', 'AppController@updateProfile');
        $router->get('myCertificates', 'AppController@myCertificates');

        $router->get('our-certificates', 'AppController@ourCertificates');
        $router->get('our-certificates/program/{slug}', 'AppController@ourCertificatesProgram');

        $router->get('search', 'AppController@search');
    });

});


