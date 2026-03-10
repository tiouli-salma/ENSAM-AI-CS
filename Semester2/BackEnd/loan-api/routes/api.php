<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::patch('loans/{id}/return', [LoanController::class, 'return']);
Route::apiResource('loans', LoanController::class);
