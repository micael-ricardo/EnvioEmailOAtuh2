<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OutlookAuthController;

// Caso queira Testar o Gmail descomente o Gmail e comente Rotas Outlook

// Rotas Gmail OAth 2.0 

// Route::get('/', function () {
//     return redirect()->route('home');
// });
// // Rotas Gmail OAth 2.0
// Route::prefix('/')->group(function(){ 
//     Route::view('home','home')->name('home');
//     Route::post('/get-token', [OAuthController::class, 'GerarToken'])->name('gerar.token');
//     Route::get('/get-token', [OAuthController::class, 'SuccessToken'])->name('token.success');
//     Route::post('/send', [MailController::class, 'doSendEmail'])->name('send.email');
// });

// Rotas Outlook OAth 2.0

Route::get('/', function () {
    return redirect()->route('homeOutlook');
});
Route::prefix('/')->group(function(){ 
    Route::view('homeOutlook','homeOutlook')->name('homeOutlook');
    Route::post('/auth/outlook', [OutlookAuthController::class, 'redirectToProvider'])->name('auth.outlook');
    Route::get('/get-token', [OutlookAuthController::class, 'handleProviderCallback'])->name('token.success');
    Route::post('/send', [MailController::class, 'doSendEmail'])->name('send');
});

