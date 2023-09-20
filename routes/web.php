<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OAuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OutlookAuthController;



Route::get('/', function () {
    return redirect()->route('home');
});
// Rotas Gmail OAth 2.0
Route::prefix('/')->group(function(){ 
    Route::view('home','home')->name('home');
    Route::post('/get-token', [OAuthController::class, 'GerarToken'])->name('gerar.token');
    Route::get('/get-token', [OAuthController::class, 'SuccessToken'])->name('token.success');
    Route::post('/send', [MailController::class, 'doSendEmail'])->name('send.email');
});

// // lINK PARA ESSA ROTA  http://127.0.0.1:8000/homeOutlook
// // Rotas Outlook OAth 2.0
// Route::prefix('/')->group(function(){ 
//     Route::view('homeOutlook','homeOutlook')->name('homeOutlook');
//     Route::post('/auth/outlook', [OutlookAuthController::class, 'redirectToProvider'])->name('auth.outlook');
//     Route::get('/auth/outlook/callback', [OutlookAuthController::class, 'handleProviderCallback'])->name('auth.outlook.callback');
//     Route::post('/send', [MailController::class, 'doSendEmail'])->name('send');
// });

