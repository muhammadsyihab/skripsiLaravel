<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::post('/login', [App\Http\Controllers\APILoginController::class, 'login']);

Route::get('/getMobileVersion', [App\Http\Controllers\ApiMobileVersion::class, 'getVersion']);


Route::group(['middleware' =>  'auth:api'], function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'notifications']);
    Route::post('/updatePassword', [App\Http\Controllers\APILoginController::class, 'updatePassword']);
    Route::get('/tickets', [App\Http\Controllers\ApiTicketController::class, 'index']);
    Route::post('/api-ticket', [App\Http\Controllers\ApiTicketController::class, 'postTicket']);
    Route::post('/api-history-ticket', [App\Http\Controllers\ApiTicketController::class, 'postHistoryTicket']);
    Route::post('/api-tindakan-ticket', [App\Http\Controllers\ApiTicketController::class, 'postTindakanTicket']);
    Route::get('/history/{id}/ticket', [App\Http\Controllers\ApiTicketController::class, 'getHistory']);
    Route::post('/ground-test', [App\Http\Controllers\ApiTicketController::class, 'groundTest']);

    Route::get('/units', [App\Http\Controllers\APIUnitController::class, 'getAllUnits']);
    Route::get('/unit', [App\Http\Controllers\APIUnitController::class, 'getUnit']);
    Route::post('/getHm', [App\Http\Controllers\APIUnitController::class, 'getHm']);

    Route::get('/jadwals', [App\Http\Controllers\APIJadwalController::class, 'jadwals']);
    Route::get('/jadwal', [App\Http\Controllers\APIJadwalController::class, 'jadwal']);
    
    Route::get('/daily/operator', [App\Http\Controllers\APIDailyController::class, 'getDailyOperator']);
    Route::get('/daily/mekanik', [App\Http\Controllers\APIDailyController::class, 'getDailyMekanik']);
    Route::get('/daily/mekanik/tasks', [App\Http\Controllers\APIDailyController::class, 'getDailyMekanikTasks']);
    Route::post('/daily/operator', [App\Http\Controllers\APIDailyController::class, 'postDailyOperator']);
    Route::post('/daily/mekanik', [App\Http\Controllers\APIDailyController::class, 'postDailyMekanik']);
    // Route::get('/daily/status', [App\Http\Controllers\APIDailyController::class, 'getStatus']);
    Route::get('/daily/status', [App\Http\Controllers\APIDailyController::class, 'getStatus']);
});

// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::get('/user', function (Request $request) {
//         return response(['user' => auth()->user()]);
//     });
// });

// Route::get('/testing', function () {
//     return response(['sfs' => auth()->user()]);
// });

// Route::get('/getUserLogin', [App\Http\Controllers\ApiTicketController::class, 'getUserLogin']);
// Route::get('/getTicket/{idTicket}', [App\Http\Controllers\ApiTicketController::class, 'index']);
// Route::get('/getHistori/{idTicket}', [App\Http\Controllers\ApiTicketController::class, 'getHistory']);

// Route::get('/getMSparepart', [App\Http\Controllers\ApiTicketController::class, 'getMSparepart']);
// Route::get('/listUsers', [App\Http\Controllers\ApiTicketController::class, 'listUsers']);

// Route::post('/postBrgKlr', [App\Http\Controllers\ApiTicketController::class, 'postbrgklr']);

// Route::patch('/updatebrgklr', [App\Http\Controllers\ApiTicketController::class, 'updatebrgklr']);

// Route::patch('/tutupTiket', [App\Http\Controllers\ApiTicketController::class, 'tutupTiket']);

// Route::post('/postHUnit', [App\Http\Controllers\ApiTicketController::class, 'postHunit']);
// Route::post('/postHTicket', [App\Http\Controllers\ApiTicketController::class, 'postHTicket']);

// Route::post('/postDOperator', [App\Http\Controllers\ApiTicketController::class, 'postDOperator']);