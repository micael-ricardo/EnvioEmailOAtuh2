<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\OAuthControllerOutlook;
use Illuminate\Support\Facades\Route;

// Caso queira Testar o Gmail descomente o Gmail e comente Rotas Outlook

// Rotas Gmail OAth 2.0

Route::get('/', function () {
    return redirect()->route('home');
});
// Rotas Gmail OAth 2.0
Route::prefix('/')->group(function(){
    Route::view('home','home')->name('home');
    Route::post('/get-token', [OAuthController::class, 'GerarToken'])->name('gerar.token');
    Route::get('/get-token', [OAuthController::class, 'SuccessToken'])->name('token.success');
    Route::post('/enviar', [MailController::class, 'doSendEmail'])->name('send.email');
});

// Rotas Outlook OAth 2.0

// Route::get('/', function () {
//     return redirect()->route('homeOutlook');
// });
// Route::prefix('/')->group(function () {
//     Route::view('homeOutlook', 'homeOutlook')->name('homeOutlook');
//     Route::post('/get-token', [OAuthControllerOutlook::class, 'GerarToken'])->name('gerar.token');
//     Route::get('/get-token', [OAuthControllerOutlook::class, 'SuccessToken'])->name('token.success');
//     Route::post('/send', [EmailController::class, 'doSendEmail'])->name('send');
// });
