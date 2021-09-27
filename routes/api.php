<?php

use App\Http\Controllers\CloudAccountController;
use App\Http\Controllers\CloudDomainController;
use App\Http\Controllers\CloudSiteController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\CloudCoinController;
use App\Http\Controllers\CloudSite;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->get('api/get_memos', function {

// });
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::group(['middleware', 'auth:api'], function () {
    Route::get('get_memos', [MemoController::class, 'getMemo']);
    Route::get('get_domain', [CloudDomainController::class, 'getDomain']);
    Route::post('create_memo', [MemoController::class, 'createMemo']);
    Route::post('delete_memo', [MemoController::class, 'deleteMemo']);
    Route::get('get_accounts', [CloudAccountController::class, 'getAccounts']);
    Route::post('add_account', [CloudAccountController::class, 'addAccount']);
    Route::get('get_site', [CloudSiteController::class, 'getSite']);
    Route::post('get_domain_list', [CloudDomainController::class, 'getDomainList']);
    Route::post('cloud_add_domain', [CloudDomainController::class, 'cloudAddDomain']);
    Route::post('update_account', [CloudAccountController::class, 'updateAccount']);
    
    Route::post('add_site', [CloudSiteController::class, 'addSite']);
    
    Route::get('get_coins', [CloudCoinController::class, 'getCoins']);

});
