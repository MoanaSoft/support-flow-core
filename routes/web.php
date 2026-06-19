<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Moanasoft\SupportFlowCore\Http\Controllers\Admin\DashboardController;
use Moanasoft\SupportFlowCore\Http\Controllers\Admin\RequestsController;
use Moanasoft\SupportFlowCore\Http\Controllers\Admin\StatsController;
use Moanasoft\SupportFlowCore\Http\Controllers\SupportFlowWidgetController;

if (config('support-flow.routes.enabled', true)) {
    Route::middleware(config('support-flow.routes.middleware', ['web']))
        ->prefix(config('support-flow.routes.prefix', 'support-flow'))
        ->name((string) config('support-flow.routes.name', 'moanasoft.support-flow.front.'))
        ->group(function (): void {
            Route::get('/instances/{instance}', [SupportFlowWidgetController::class, 'show'])->name('instances.show');
            Route::post('/instances/{instance}/intents/{intent}', [SupportFlowWidgetController::class, 'intent'])->name('instances.intents');
            Route::post('/instances/{instance}/workflows/{workflow}/complete', [SupportFlowWidgetController::class, 'complete'])->name('instances.workflows.complete');
            Route::post('/instances/{instance}/contact-opened', [SupportFlowWidgetController::class, 'contactOpened'])->name('instances.contact-opened');
            Route::post('/instances/{instance}/contact', [SupportFlowWidgetController::class, 'contact'])->name('instances.contact');
        });

    Route::middleware(config('support-flow.routes.backoffice.middleware', config('support-flow.routes.admin.middleware', ['web', 'auth'])))
        ->prefix(config('support-flow.routes.backoffice.prefix', config('support-flow.routes.admin.prefix', 'backoffice/support-flow')))
        ->name((string) config('support-flow.routes.backoffice.name', 'moanasoft.support-flow.backoffice.'))
        ->group(function (): void {
            Route::get('/', DashboardController::class)->name('dashboard');
            Route::get('/stats', StatsController::class)->name('stats');
            Route::get('/requests', [RequestsController::class, 'index'])->name('requests.index');
            Route::get('/requests/{id}', [RequestsController::class, 'show'])->name('requests.show');
        });
}
