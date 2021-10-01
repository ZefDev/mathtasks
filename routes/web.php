<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SolvingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AnswerController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('login/{provider}', [SocialController::class, 'redirect']);
Route::get('login/{provider}/callback', [SocialController::class, 'Callback']);

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])
    ->get('/alltasks', [TaskController::class, 'indexAllTasks'])->name('alltasks');

Route::middleware(['auth:sanctum', 'verified'])->get('/admin',
    [UserController::class, 'index']
)->name('admin');

Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks',
    [TaskController::class, 'indexMyTasks']
)->name('mytasks');

Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks/new',
    [TaskController::class, 'indexNewTask']
)->name('new.task');

Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks/{id}/edit',
    [TaskController::class, 'indexEditTask']
)->name('new.edit');

Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks/{id}/view',
    [TaskController::class, 'indexViewTask']
)->name('task.view');

//Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks', function () {
//    return Inertia::render('MyTasks/container');
//})->name('mytasks');

//Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks/new', function () {
//    return Inertia::render('MyTasks/New/container');
//})->name('new.task');

//Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks/{id}/edit', function () {
//    return Inertia::render('MyTasks/Edit/container');
//})->name('new.edit');

//Route::middleware(['auth:sanctum', 'verified'])->get('/mytasks/{id}/view', function () {
//    return Inertia::render('MyTasks/View/container');
//})->name('task.view');

Route::get('language/{language}', function ($language) {
    Session()->put('locale', $language);
    return redirect()->back();
})->name('language');


Route::get('/admin/users', [UserController::class, 'users']);
Route::get('/admin/users/{id}/delete', [UserController::class, 'delete']);
Route::get('/admin/users/{id}/set-block', [UserController::class, 'setBlock']);
Route::get('/admin/users/{id}/set-admin', [UserController::class, 'setAdmin']);

Route::get('/admin/tasks', [TaskController::class, 'tasks']);
//Route::get('/task/task-current-user', [TaskController::class, 'getTaskCurrentUser']);
//Route::get('/task/achievements-user', [TaskController::class, 'getUserAchievements']);
Route::post('/task/create', [TaskController::class, 'create']);
Route::post('/task/update/{id}', [TaskController::class, 'update']);
Route::get('/task/delete/{id}', [TaskController::class, 'delete']);


Route::get('/theme', [ThemeController::class, 'themes']);

Route::get('/image/delete/{id}', [ImageController::class, 'delete']);

Route::get('/answer/delete/{id}', [AnswerController::class, 'delete']);

Route::post('/solving/create', [SolvingController::class, 'create']);

Route::post('/comment/create', [CommentController::class, 'createComment']);
Route::get('/comments/{id}', [CommentController::class, 'getComments']);

Route::post('/like', [LikeController::class, 'like']);

Route::post('/raiting', [RatingController::class, 'setRaiting']);

