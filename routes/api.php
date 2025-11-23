<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\ContactController;

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
Route::get('/about', [FrontendController::class, 'about']);
Route::get('/gallery', [FrontendController::class, 'gallery']);
Route::get('/gallery-categories', [FrontendController::class, 'categories']);
Route::get('/gallery/{category_id}', [FrontendController::class, 'byCategory']);
Route::get('/volunteer', [FrontendController::class, 'membership']);
Route::post('/volunteer-register', [VolunteerController::class, 'store']);
Route::post('/contact-submit', [ContactController::class, 'store']);
Route::get('/project', [FrontendController::class, 'projects']);
Route::get('/complete-project', [FrontendController::class, 'completeprojects']);
Route::get('/project/{id}', [FrontendController::class, 'projectDetails']);
Route::get('/active-project', [FrontendController::class, 'projectActive']);

