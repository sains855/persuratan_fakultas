<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FcmController;

Route::post('/fcm/save-token', [FcmController::class, 'saveToken']);