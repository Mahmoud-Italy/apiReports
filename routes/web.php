<?php
use Lararoutes\Lumen\CustomRoutes;
$app = new CustomRoutes($router);


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/clear-cache', function(){
    \Cache::flush();
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

        $router->get('applications/{type}', 'ApplicationController@index');
        $router->get('applications/{type}/{id}', 'ApplicationController@show');
        $router->get('applications/{type}/export/file', 'ApplicationController@export');
        $router->delete('applications/{type}/{id}', 'ApplicationController@destroy');

        $app->apiResource('memberships', 'MembershipController');
        $app->apiResource('about', 'AboutController');
        $app->apiResource('contacts', 'SettingController');
        $app->apiResource('settings', 'SettingController');
        $app->apiResource('certificates', 'CertificateController');
        $app->apiResource('cert-products', 'CProductController');
        $app->apiResource('inbox', 'InboxController');
        $app->apiResource('media', 'MediaController');
        $app->apiResource('trainings', 'TrainingController');
        $app->apiResource('members', 'MemberController');
        $app->apiResource('instructors', 'InstructorController');
        $app->apiResource('experiences', 'ExperienceController');
        $app->apiResource('users', 'UserController');
        $app->apiResource('pages', 'PageController');
        $app->apiResource('faqs', 'FaqController');
        $app->apiResource('modern-app', 'ModernAppController');
        $app->apiResource('new-app', 'NewAppController');
        $app->apiResource('searchs', 'SearchController');
        $app->apiResource('products2', 'Product2Controller');
        $app->apiResource('privacy', 'PrivacyController');
        $app->apiResource('events', 'EventController');
        $app->apiResource('online', 'OnlineController');
        $app->apiResource('socials', 'SocialController');
        $app->apiResource('subscribers', 'SubscriberController');
        $app->apiResource('emails', 'EmailTemplateController');
    });







    /** Frontend **/
    $router->group(['namespace' => 'Frontend'], function($router) use ($app) {
        $app->authResource('auth', 'AuthController');
        $router->get('countries', 'AppController@countries');
        $router->get('home', 'PageController@home');
        
        $router->get('popularSearch', 'AppController@popular');
        $router->get('popularSearch/{slug}', 'AppController@showPopular');
        $router->get('popularSearch/shortcut/{slug}', 'AppController@showShortcutPopular');
        $router->get('popularSearch/in/programs/{slug}', 'AppController@showProgramsPopularSearch');

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
        
        $router->get('new-applications/{id}', 'AppController@newApp');
        $router->post('new-applications', 'AppController@doNewApp');

        $router->get('trainings-applications', 'AppController@trainings');
        $router->post('trainings-applications', 'AppController@doTrainings');

        $router->get('members-applications', 'AppController@members');
        $router->post('members-applications', 'AppController@doMembers');

        $router->get('instructor-applications', 'AppController@instructor');
        $router->post('instructor-applications', 'AppController@doInstructor');

        $router->get('experience-applications', 'AppController@experience');
        $router->post('experience-applications', 'AppController@doExperience');

        $router->get('faqs', 'AppController@faqs');
        $router->get('privacy', 'AppController@privacy');
        $router->get('events', 'PageController@events');
        $router->get('online-trainings', 'AppController@online');
        $router->get('online-trainings/{slug}', 'AppController@showOnline');
        $router->post('newsletters', 'AppController@newsletters');
        $router->get('pages', 'PageController@index');
        $router->get('pages/{slug}', 'PageController@show');
        
        $router->get('myProfile', 'AppController@profile');
        $router->post('myProfile', 'AppController@updateProfile');
        $router->get('myCertificates', 'AppController@myCertificates');

        $router->get('our-certificates', 'AppController@ourCertificates');
        $router->get('our-certificates/program/{slug}', 'AppController@ourCertificatesProgram');
        
        $router->get('search', 'AppController@search');
        $router->get('socials', 'AppController@socials');
        $router->get('setting', 'AppController@setting');
    });

});


