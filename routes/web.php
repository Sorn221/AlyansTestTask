<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;

//region common
Route::get('/', function () {return view('common.home'); })->name('home');
Route::get('/home', function () { return redirect('/'); })->name('home');
Route::get('/comments', [ReviewController::class, 'getReviews'])->name('comments');
Route::get('/privacy', function () { return view('common.privacy'); })->name('privacy');
//endregion

//region profile
Route::get('/profile', [ProfileController::class, 'getUserProfile'])->name('profile')->middleware('auth');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password')->middleware('auth');
Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload-photo')->middleware('auth');
//endregion

//region authentication
Auth::routes();
Route::get('/logout', function () {Auth::logout(); return redirect('/');})->name('logout');
Route::get('/authentication', function () {return view('auth.authentication');})->name('authentication');
Route::get('/password-recovery', function () {return view('auth.password-recovery');})->name('password-recovery');
Route::get('/check-auth', function () {return response()->json(['authorized' => Auth::check(),'user' => Auth::check() ? Auth::user() : null,]);});
Route::post('/check-email', [AuthController::class, 'checkEmail']);
Route::post('/send-reset-link', [AuthController::class, 'sendResetLink']);
//endregion

//region reviews
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{id}', [ReviewController::class, 'getReviewById'])->name('reviews.show');
Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');

Route::get('/reviews/search/{search}', [ReviewController::class, 'search'])->name('reviews.search');

Route::get('/reviews/sort/{sort}', [ReviewController::class, 'sort'])->name('reviews.sort');
//endregion
