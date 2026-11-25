<?php

use App\Http\Controllers\CatatanController;
use Illuminate\Support\Facades\Route;

Route::apiResource('catatan', CatatanController::class)
    ->parameters(['catatan' => 'id']);