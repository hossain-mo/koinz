<?php

use App\Http\Controllers\BookCalculationController;
use Illuminate\Support\Facades\Route;

Route::resource('/intervals', BookCalculationController::class)->only(['index', 'store']);
