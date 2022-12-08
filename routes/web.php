<?php

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('/live/{token}', 'App\Http\Controllers\WebrtcStreamingController@startLive');


Route::group(['middleware' => ['auth']], function () {


    Route::get('/video-chat', function () {
        // fetch all users apart from the authenticated user
        $users = User::where('id', '<>', Auth::id())->get();
        return view('video-chat', ['users' => $users]);
    });

    // Endpoints to alert call or receive call.
    Route::post('/video/call-user', 'App\Http\Controllers\VideoChatController@callUser');
    Route::post('/video/accept-call', 'App\Http\Controllers\VideoChatController@acceptCall');

    // Agora Video Call Endpoints
    Route::get('/agora-chat', 'App\Http\Controllers\AgoraVideoController@index');
    Route::post('/agora/token', 'App\Http\Controllers\AgoraVideoController@token');
    Route::post('/agora/call-user', 'App\Http\Controllers\AgoraVideoController@callUser');


    // WebRTC Group Call Endpoints
    // Initiate Stream, Get a shareable broadcast link
    Route::get('/test', 'App\Http\Controllers\HomeController@test');

    Route::get('/streaming', 'App\Http\Controllers\WebrtcStreamingController@index');
    Route::get('/streaming/{streamId}', 'App\Http\Controllers\WebrtcStreamingController@consumer');
    Route::post('/stream-offer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamOffer');
    Route::post('/stream-answer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamAnswer');
    Route::post('/notify', 'App\Http\Controllers\WebrtcStreamingController@liveNotify');

    Route::prefix('chat')->group(function () {
        Route::post('messages', [\App\Http\Controllers\ChatController::class, 'sendMessage']);
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('live.home');
        Route::get('/create', [DashboardController::class, 'create'])->name('live.create');
        Route::get('/live/{live_id}', [DashboardController::class, 'live'])->name('live.streaming');
        Route::post('/live/set/started', [DashboardController::class, 'liveStarted'])->name('live.started');
        Route::post('/live/set/ended', [DashboardController::class, 'liveEnded'])->name('live.ended');
        Route::post('/store', [DashboardController::class, 'store'])->name('live.store');
        Route::get('/playback', [DashboardController::class, 'playback'])->name('live.playback');
        Route::get('/video-streaming', [DashboardController::class, 'videoStreaming'])->name('live.video-streaming');

        Route::get('/statistic', [DashboardController::class, 'statistic'])->name('dashboard.statistic');
        Route::get('/calendar', [DashboardController::class, 'calendar'])->name('dashboard.calendar');
        Route::get('/users', [DashboardController::class, 'users'])->name('dashboard.users');
    });
});

/**
 * When you clone the repository, comment out
 *  Auth::routes(['register' => false]);
 * and uncomment
 *   Auth::routes()
 * so that you can register new users. I disabled the registration endpoint so that my hosted demo won't be abused.
 * 
 */
Auth::routes();
//Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


