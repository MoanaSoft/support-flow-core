<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Moanasoft\SupportFlowCore\Http\Controllers\Admin\DashboardController;
use Moanasoft\SupportFlowCore\Http\Controllers\Admin\RequestsController;
use Moanasoft\SupportFlowCore\Http\Controllers\Admin\StatsController;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/stats', StatsController::class)->name('stats');
Route::get('/requests', [RequestsController::class, 'index'])->name('requests.index');
Route::get('/requests/{id}', [RequestsController::class, 'show'])->name('requests.show');
