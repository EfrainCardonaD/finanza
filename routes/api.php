<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserIncomesController;
use App\Http\Controllers\Api\UserExpensesController;
use App\Http\Controllers\Api\CategoryExpensesController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('categories', CategoryController::class);

        // Category Expenses
        Route::get('/categories/{category}/expenses', [
            CategoryExpensesController::class,
            'index',
        ])->name('categories.expenses.index');
        Route::post('/categories/{category}/expenses', [
            CategoryExpensesController::class,
            'store',
        ])->name('categories.expenses.store');

        Route::apiResource('expenses', ExpenseController::class);

        Route::apiResource('incomes', IncomeController::class);

        Route::apiResource('users', UserController::class);

        // User Expenses
        Route::get('/users/{user}/expenses', [
            UserExpensesController::class,
            'index',
        ])->name('users.expenses.index');
        Route::post('/users/{user}/expenses', [
            UserExpensesController::class,
            'store',
        ])->name('users.expenses.store');

        // User Incomes
        Route::get('/users/{user}/incomes', [
            UserIncomesController::class,
            'index',
        ])->name('users.incomes.index');
        Route::post('/users/{user}/incomes', [
            UserIncomesController::class,
            'store',
        ])->name('users.incomes.store');
    });
