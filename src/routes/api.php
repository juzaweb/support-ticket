<?php

use Illuminate\Support\Facades\Route;
use Juzaweb\Modules\SupportTicket\Http\Controllers\API\SupportTicketController;

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

Route::group(
    [
        'middleware' => ['auth:api'],
        'prefix' => 'api/v1',
    ],
    function () {
        Route::get('support-tickets', [SupportTicketController::class, 'index']);
        Route::post('support-tickets', [SupportTicketController::class, 'store']);
        Route::post('support-tickets/{id}/reply', [SupportTicketController::class, 'reply']);
    }
);
