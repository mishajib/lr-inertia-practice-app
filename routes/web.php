<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::inertia('/', 'WelcomeComponent');
Route::inertia('/about', 'AboutComponent');

Route::get('/contact', function () {
    return Inertia::render('ContactComponent', [
        'page_title' => 'Contact Us'
    ]);
});
Route::resource('/contacts', ContactController::class);

