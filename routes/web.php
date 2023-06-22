<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DptController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogController;

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


Route::fallback(function () {
    return redirect()->route('page_login');
});

Route::group(['middleware' => ['revalidate']], function () {

    Route::get('/', [LoginController::class, 'page_login'])->name('page_login')->middleware('blockLoginByBrowser');
    Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('blockLoginByBrowser');
});


Route::group(['middleware' => ['auth', 'blockLoginByBrowser', 'revalidate']], function () {

    Route::get('home', [HomeController::class, 'index'])->name('home');

    // Rsvp Munas
    Route::get('rsvp', [ReservationController::class, 'create'])->name('rsvp')->middleware('first.submit.rsvp');
    Route::post('rsvp', [ReservationController::class, 'store'])->name('rsvp_store')->middleware('first.submit.rsvp');
    // Route::get('rsvp_attendance/{code_rsvp}', [ReservationController::class, 'rsvp_attendance'])->name('rsvp_attendance');

    Route::get('rsvp_success', [ReservationController::class, 'rsvp_success'])->name('rsvp_success');

    // Route::get('rsvp_success', function () {
    //     return view('thankyou_rsvp');
    // })->name('rsvp_success');


    //  E-Voting 
    Route::controller(VoteController::class)->group(function () {

        Route::get('vote_candidate', 'vote_candidate')->name('vote_candidate')->middleware('form.submission.dpt');
        Route::post('vote_candidate_store', 'vote_candidate_store')->name('vote_candidate_store')->middleware('form.submission.dpt');
        Route::get('vote_confirmation', 'vote_confirmation')->name('vote_confirmation')->middleware('form.submission.dpt');
        Route::post('vote_submit', 'vote_submit')->name('vote_submit')->middleware('form.submission.dpt');

        Route::get('vote_success', function () {
            return view('thankyou');
        })->name('vote_success');
    });


    //  Daftar Pemilih Tetap
    Route::controller(DptController::class)->group(function () {
        Route::get('dpt', 'create')->name('dpt')->middleware('first.submit.dpt');
        Route::post('dpt', 'store')->name('dpt_store')->middleware('first.submit.dpt');

        Route::get('dpt_success', function () {
            return view('thankyou_dpt');
        })->name('dpt_success');
    });


    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});


Route::get('logview', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('log', [LogController::class, 'log']);