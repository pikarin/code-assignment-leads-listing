<?php

use App\Http\Controllers\LeadsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('leads', LeadsController::class);
