<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//rotas de autenticacao
Route::group(['middleware' => 'api'], function ($router) 
{
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/refresh', [AuthController::class, 'refresh']);
  Route::get('/userprofile', [AuthController::class, 'userProfile']);
});


//rotas com validacao do JWT 
Route::group(['middleware' => 'jwt'], function ($router) 
{  
  //status
  Route::group(['prefix' => 'status'], function ($router) 
  {
    Route::get('/', [StatusController::class, 'list']);
    Route::post('/', [StatusController::class, 'add']);
    Route::delete('/{id}', [StatusController::class, 'delete']);
    Route::put('/{id}', [StatusController::class, 'update']);
  });

  //tasks - tarefas
  Route::group(['prefix' => 'tasks'], function ($router) 
  {
    Route::get('/', [TasksController::class, 'list']);
    Route::post('/', [TasksController::class, 'add']);
    Route::delete('/{id}', [TasksController::class, 'delete']);
    Route::put('/{id}', [TasksController::class, 'update']);
  });  
});

