<?php

use App\Http\Controllers\API\ApiNewsController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\DashboardArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Login & logout
Route::post('/login',[LoginController::class,'authenticate']);
Route::get('logout',[LoginController::class,'logout'])->middleware('auth:sanctum');
Route::get('me',[LoginController::class,'me'])->middleware('auth:sanctum');
Route::post('/register',[RegisterController::class,'store'])->middleware('guest');
Route::get('/users',[RegisterController::class,'index']);

Route::get('/news',[ApiNewsController::class,'index']);


// Category
Route::post('/new-category',[CategoryController::class,'store']);
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/category/{category:id}',[CategoryController::class,'show2']);

// Article
Route::get('/articles',[ArticleController::class,'index']);
//Route::post('/new-article',[ArticleController::class,'store'])->middleware('auth:sanctum');
Route::get('/article/{article:slug}',[ArticleController::class,'show']);
// Route::put('/update-article/{article:slug}',[ArticleController::class,'update'])->middleware(['auth:sanctum']);
// Route::delete('/delete-article/{article:slug}',[ArticleController::class,'destroy'])->middleware(['auth:sanctum']);

// Comment
Route::post('/add-comment',[CommentController::class,'store'])->middleware('auth:sanctum');

// Article Dashboard
Route::get('/dashboard/articles',[DashboardArticleController::class,'index'])->middleware('auth:sanctum');
Route::post('/dashboard/new-article',[DashboardArticleController::class,'store']);
Route::get('/dashboard/article/edit/{article:slug}',[DashboardArticleController::class,'edit'])->middleware('auth:sanctum');
Route::put('/dashboard/article/edit/{article:slug}',[DashboardArticleController::class,'update'])->middleware('auth:sanctum');
Route::delete('/dashboard/article/delete/{article:slug}',[DashboardArticleController::class,'destroy'])->middleware('auth:sanctum');
// Route::middleware('guest')->group(function(){

// });