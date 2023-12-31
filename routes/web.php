<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Media\HomeController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\TvController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\FilesController;
use \App\Http\Controllers\LinksController;
use \App\Http\Controllers\PanelController;
use \App\Http\Controllers\ShareController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::any('/api/v1/sonarr', [ApiController::class, 'sonarr']);
Route::any('/api/v1/radarr', [ApiController::class, 'radarr']);


Route::group(['prefix' => '/media', 'middleware' => ['IpMiddleware']], function() {
    Route::get('/', [HomeController::class,    'index'])->name('media_home');

});


Route::group(['prefix' => '/sharing', 'middleware' => ['IpMiddleware']], function() {
    Route::get('/',                                 [PanelController::class,    'index'])->name('home');

    Route::get('/shares',                           [ShareController::class,    'index'])->name('shares');
    Route::get('/link/new',                         [ShareController::class,    'linkNew'])->name('link_new');
    Route::get('/link/del/{link_slug}',             [ShareController::class,    'linkDel'])->name('link_del');
    Route::get('/link/item/del/{link_item_slug}',   [ShareController::class,    'linkItemDel'])->name('link_item_del');
    Route::post('/link/items/add',                  [ShareController::class,    'linkItemAdd'])->name('link_item_add');

    Route::get('/test',   [ShareController::class,    'test'])->name('test');


    Route::group(['prefix' => '/tv'], function() {
        Route::any('/',                        [TvController::class,       'index'])->name('tv_home');
        Route::get('/list/{link_slug}',        [TvController::class,       'list'])->name('tv_show');
        Route::get('/refresh/list',            [TvController::class,       'refreshList'])->name('tv_refresh_all');
        Route::get('/refresh/media/{media_id}',[TvController::class,       'refreshMedia'])->name('tv_refresh_show');
        Route::get('/list/media/{media_id?}',  [TvController::class,       'listMedia'])->name('showlist');
    });

    Route::group(['prefix' => '/movies'], function() {
        Route::any('/',                        [MoviesController::class,   'index'])->name('movies_home');
        Route::get('/refresh/list',            [MoviesController::class,   'refreshList'])->name('movies_refresh_list');
        Route::get('/refresh/media/{media_id}',[MoviesController::class,   'refreshMedia'])->name('movies_refresh_movie');
        Route::get('/list/media/{media_id?}',  [MoviesController::class,   'listMedia'])->name('movielist');
    });

    Route::get('/force/{file_id}',             [DownloadController::class, 'force'])->name('force');


});

Route::post('/link/login/{link_slug}',      [DownloadController::class, 'login'])->name('login');
Route::get('/link/{link_slug}',             [DownloadController::class, 'fetch'])->name('fetch');
Route::get('/link/{link_slug}/{link_id}',   [DownloadController::class, 'download'])->name('download');

Route::get('/', function () {
    return view('welcome');
});
