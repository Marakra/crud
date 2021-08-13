<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('/users')
    ->name('users.')
    ->group(static function (): void {
        Route::post('/', [UserController::class, 'createUser'])->name('create');
        Route::get('/', [UserController::class, 'getAllUsers'])->name('all');
        Route::get('/{userId}', [UserController::class, 'getOneUserById'])->name('oneById');
        Route::post('/{userId}', [UserController::class, 'updateUser']) -> name('update');
        Route::delete('/{userId}', [UserController::class, 'deleteUser'])->name('delete');
    });
