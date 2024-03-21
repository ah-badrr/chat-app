<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $contacts = Contact::where('maker', '=', Auth::user()->id)
    ->get();
    return view('master.app',compact('contacts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/app', function () {
        return view('master.app');
    });
    Route::resource('/contact', ContactController::class);
    Route::resource('/chat', ChatController::class);
    Route::put('/chat/destroyme/{id}', [ChatController::class, 'destroyme'])->name('chat.destroyme');
    Route::get('/chat/group/{id}', [ChatController::class, 'group'])->name('chat.group');
    Route::put('/chat/clear/{id}', [ChatController::class, 'clear'])->name('chat.clear');
    Route::post('/chat/store/{id}', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/chat/storeG/{id}', [ChatController::class, 'storeG'])->name('chat.storeG');
});

require __DIR__ . '/auth.php';
