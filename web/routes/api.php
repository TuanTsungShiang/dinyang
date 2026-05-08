<?php

use App\Http\Controllers\DeployController;
use Illuminate\Support\Facades\Route;

Route::post('/deploy', [DeployController::class, 'handle']);
