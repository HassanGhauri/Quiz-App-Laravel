<?php

use App\Http\Controllers\Api\McqsController;
use App\Http\Controllers\Api\QuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserResultController;

Route::prefix('cqs')->group(function () {

    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users/{id}', [UserController::class, 'show']);

    Route::post('/users', [UserController::class, 'store']);

    Route::put('/users/{id}', [UserController::class, 'update']);

    Route::delete('/users/{id}', [UserController::class, 'delete']);

     Route::get('/quizzes', [QuizController::class, 'index']);

    Route::get('/quizzes/{id}', [QuizController::class, 'show']);

    Route::post('/quizzes', [QuizController::class, 'store']);

    Route::put('/quizzes/{id}', [QuizController::class, 'update']);

    Route::delete('/quizzes/{id}', [QuizController::class, 'delete']);

    Route::get('/mcqs', [McqsController::class, 'index']);

    Route::get('/mcqs/{id}', [McqsController::class, 'show']);

    Route::post('/mcqs', [McqsController::class, 'store']);

    Route::put('/mcqs/{id}', [McqsController::class, 'update']);

    Route::delete('/mcqs/{id}', [McqsController::class, 'delete']);

      Route::get('/results', [UserResultController::class, 'index']);

    Route::get('/results/{id}', [UserResultController::class, 'show']);

    Route::post('/results', [UserResultController::class, 'store']);

    Route::put('/results/{id}', [UserResultController::class, 'update']);

    Route::delete('/results/{id}', [UserResultController::class, 'delete']);


});