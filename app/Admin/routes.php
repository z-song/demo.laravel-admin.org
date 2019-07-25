<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resources([

        'tags'                  => TagController::class,
        'users'                 => UserController::class,
        'images'                => ImageController::class,
        'posts'                 => PostController::class,
        'post-comments'         => PostCommentController::class,
        'videos'                => VideoController::class,
        'articles'              => ArticleController::class,
        'painters'              => PainterController::class,
        'categories'            => CategoryController::class,
        'messages'              => MessageController::class,
        'multiple-images'       => MultipleImageController::class,

        'movies/in-theaters'    => Movies\InTheaterController::class,
        'movies/coming-soon'    => Movies\ComingSoonController::class,
        'movies/top250'         => Movies\Top250Controller::class,

        'world/country'         => World\CountryController::class,
        'world/city'            => World\CityController::class,
        'world/language'        => World\LanguageController::class,

        'china/province'        => China\ProvinceController::class,
        'china/city'            => China\CityController::class,
        'china/district'        => China\DistrictController::class,

        'subway/cities'         => Subway\CityController::class,
        'subway/lines'          => Subway\LineController::class,
        'subway/stops'          => Subway\StopController::class,

        'documents'             => DocumentController::class,
    ]);

    $router->group(['prefix' => 'editors'], function ($router) {
        $router->get('markdown', EditorsController::class.'@markdown');
        $router->get('wang-editor', EditorsController::class.'@wangEditor');
        $router->get('summernote', EditorsController::class.'@summernote');
        $router->get('json', EditorsController::class.'@json');
    });

    $router->group(['prefix' => 'code-mirror'], function ($router) {
        $router->get('clike', CodemirrorController::class.'@clike');
        $router->get('php', CodemirrorController::class.'@php');
        $router->get('js', CodemirrorController::class.'@js');
        $router->get('python', CodemirrorController::class.'@python');
    });

    $router->group(['prefix' => 'lightbox'], function ($router) {
        $router->get('lightbox', LightboxController::class.'@lightbox');
        $router->get('gallery', LightboxController::class.'@gallery');
    });

    $router->post('posts/release', 'PostController@release');
    $router->post('posts/restore', 'PostController@restore');
    $router->get('api/users', 'PostController@users');

    $router->get('china/cascading-select', 'China\ChinaController@cascading');

    $router->get('api/world/cities', 'World\ApiController@cities');
    $router->get('api/world/countries', 'World\ApiController@countries');
    $router->get('api/china/city', 'China\ChinaController@city');
    $router->get('api/china/district', 'China\ChinaController@district');

    $router->get('forms/form-1', 'FormController@form1');
    $router->get('forms/form-2', 'FormController@form2');
    $router->get('forms/form-3', 'FormController@form3');
    $router->get('forms/form-4', 'FormController@form4');
    $router->get('forms/settings', 'FormController@settings');
    $router->get('forms/register', 'FormController@register');

    $router->get('widgets/table', 'WidgetsController@table');
    $router->get('widgets/box', 'WidgetsController@box');
    $router->get('widgets/info-box', 'WidgetsController@infoBox');
    $router->get('widgets/tab', 'WidgetsController@tab');
    $router->get('widgets/notice', 'WidgetsController@notice');
    $router->get('widgets/editors', 'WidgetsController@editors');

    $router->get('chartjs', 'ChartjsController@index');
});
