<?php


/*
|--------------------------------------------------------------------------
| Dashboard Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Dashboard\Auth\AdminAuthController;
use App\Http\Controllers\Dashboard\LiveChatController;
use App\Http\Controllers\Dashboard\LiveController;
use App\Http\Controllers\DashboardController;

Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {

    // Login dashboard
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('loginPage');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('login');

    Route::group(['middleware' => 'adminauth'], function () {

        //Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        //Dashobard home page
        Route::get('/',[DashboardController::class, 'home'])->name('home');

        // Chat Controller
        Route::prefix('chat')->group(function () {
            Route::post('messages', [LiveChatController::class, 'sendMessage']);
            Route::post('/get/messages', [LiveChatController::class, 'getMessages']);
        });

        // Live Controller
        Route::prefix('live')->group(function () {
            Route::get('/', [LiveController::class, 'index'])->name('live.home');
            Route::get('/create', [LiveController::class, 'create'])->name('live.create');
            Route::post('/store', [LiveController::class, 'store'])->name('live.store');
            Route::get('/{live_id}', [LiveController::class, 'live'])->name('live.streaming');
            Route::post('/set/started', [LiveController::class, 'liveStarted'])->name('live.started');
            Route::post('/set/ended', [LiveController::class, 'liveEnded'])->name('live.ended');
        });

    Route::get('/playback', [DashboardController::class, 'playback'])->name('live.playback');
    Route::get('/video-streaming', [DashboardController::class, 'videoStreaming'])->name('live.video-streaming');

    Route::get('/statistic', [DashboardController::class, 'statistic'])->name('statistic');
    Route::get('/calendar', [DashboardController::class, 'calendar'])->name('calendar');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');


    });
});

//Route::prefix('dashboard')->group(function () {
//
//    Route::prefix('live')->group(function () {
//        Route::get('/', [LiveController::class, 'index'])->name('live.home');
//        Route::get('/create', [LiveController::class, 'create'])->name('live.create');
//        Route::post('/store', [LiveController::class, 'store'])->name('live.store');
//        Route::get('/{live_id}', [LiveController::class, 'live'])->name('live.streaming');
//        Route::post('/set/started', [LiveController::class, 'liveStarted'])->name('live.started');
//        Route::post('/set/ended', [LiveController::class, 'liveEnded'])->name('live.ended');
//    });
//
//    //Route::get('/', [DashboardController::class, 'index'])->name('live.home');
//    //Route::get('/create', [DashboardController::class, 'create'])->name('live.create');
//    //Route::get('/live/{live_id}', [DashboardController::class, 'live'])->name('live.streaming');
//    //Route::post('/live/set/started', [DashboardController::class, 'liveStarted'])->name('live.started');
//    //Route::post('/live/set/ended', [DashboardController::class, 'liveEnded'])->name('live.ended');
//    //Route::post('/store', [DashboardController::class, 'store'])->name('live.store');
//    Route::get('/playback', [DashboardController::class, 'playback'])->name('live.playback');
//    Route::get('/video-streaming', [DashboardController::class, 'videoStreaming'])->name('live.video-streaming');
//
//    Route::get('/statistic', [DashboardController::class, 'statistic'])->name('dashboard.statistic');
//    Route::get('/calendar', [DashboardController::class, 'calendar'])->name('dashboard.calendar');
//    Route::get('/users', [DashboardController::class, 'users'])->name('dashboard.users');
//});
