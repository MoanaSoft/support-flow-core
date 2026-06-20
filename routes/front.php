<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Moanasoft\SupportFlowCore\Http\Controllers\SupportFlowWidgetController;

Route::get('/instances/{instance}', [SupportFlowWidgetController::class, 'show'])->name('instances.show');
Route::post('/instances/{instance}/intents/{intent}', [SupportFlowWidgetController::class, 'intent'])->name('instances.intents');
Route::post('/instances/{instance}/workflows/{workflow}/complete', [SupportFlowWidgetController::class, 'complete'])->name('instances.workflows.complete');
Route::post('/instances/{instance}/contact-opened', [SupportFlowWidgetController::class, 'contactOpened'])->name('instances.contact-opened');
Route::post('/instances/{instance}/contact', [SupportFlowWidgetController::class, 'contact'])->name('instances.contact');
