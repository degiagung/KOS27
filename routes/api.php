<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\sendemail;
use App\Http\Controllers\Mail;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('send-email', function () {
    $email = new sendemail();
    // Mail::to($request->user())->send(new MailableClass);
    Mail::to('degijustin4@gmail.com')->send($email);

    return 'success';
});