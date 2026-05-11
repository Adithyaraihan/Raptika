<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Rekayasa\ApplicationReplicationController;
use App\Http\Controllers\Rekayasa\MentoringPerformanceController;
use App\Http\Controllers\Intop\IntegrationSummaryController;
use App\Http\Controllers\Intop\ServiceCatalogController;
use App\Http\Controllers\Sidebar\DocumentStatController;
use App\Http\Controllers\Sidebar\MetricController;
use App\Http\Controllers\Sidebar\OpdUsageController;
use App\Http\Controllers\SmartJabar\IndexController as SmartJabarIndexController;
use App\Http\Controllers\SmartJabar\JoinedAppController;
use App\Http\Controllers\SmartJabar\UsageStatController;
use App\Http\Controllers\SadaJabar\AppIntegrationController;
use App\Http\Controllers\SadaJabar\EncryptionStatController;
use App\Http\Controllers\SadaJabar\IndexController as SadaJabarIndexController;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);

    Route::prefix('smartjabar')->group(function () {
        Route::get('/joined-apps', [SmartJabarIndexController::class, 'index']);
        Route::get('/joined-apps/create', [JoinedAppController::class, 'create']);
        Route::post('/joined-apps', [JoinedAppController::class, 'store']);
        Route::get('/joined-apps/{id}/edit', [JoinedAppController::class, 'edit']);
        Route::put('/joined-apps/{id}', [JoinedAppController::class, 'update']);
        Route::delete('/joined-apps/{id}', [JoinedAppController::class, 'destroy']);

        Route::get('/stats/create', [UsageStatController::class, 'create']);
        Route::post('/stats', [UsageStatController::class, 'store']);
        Route::get('/stats/{id}/edit', [UsageStatController::class, 'edit']);
        Route::put('/stats/{id}', [UsageStatController::class, 'update']);
        Route::delete('/stats/{id}', [UsageStatController::class, 'destroy']);
    });

    Route::prefix('sadajabar')->group(function () {
        Route::get('/', [SadaJabarIndexController::class, 'index']);

        Route::get('/integrasi/create', [AppIntegrationController::class, 'create']);
        Route::post('/integrasi', [AppIntegrationController::class, 'store']);
        Route::get('/integrasi/{id}/edit', [AppIntegrationController::class, 'edit']);
        Route::put('/integrasi/{id}', [AppIntegrationController::class, 'update']);
        Route::delete('/integrasi/{id}', [AppIntegrationController::class, 'destroy']);

        Route::get('/enkripsi/create', [EncryptionStatController::class, 'create']);
        Route::post('/enkripsi', [EncryptionStatController::class, 'store']);
        Route::get('/enkripsi/{id}/edit', [EncryptionStatController::class, 'edit']);
        Route::put('/enkripsi/{id}', [EncryptionStatController::class, 'update']);
        Route::delete('/enkripsi/{id}', [EncryptionStatController::class, 'destroy']);
    });

    Route::prefix('rekayasa')->group(function () {
        Route::get('/application-replications', [ApplicationReplicationController::class, 'index']);
        Route::get('/application-replications/create', [ApplicationReplicationController::class, 'create']);
        Route::post('/application-replications', [ApplicationReplicationController::class, 'store']);
        Route::get('/application-replications/{id}/edit', [ApplicationReplicationController::class, 'edit']);
        Route::put('/application-replications/{id}', [ApplicationReplicationController::class, 'update']);
        Route::delete('/application-replications/{id}', [ApplicationReplicationController::class, 'destroy']);

        Route::get('/mentoring-performances', [MentoringPerformanceController::class, 'index']);
        Route::get('/mentoring-performances/create', [MentoringPerformanceController::class, 'create']);
        Route::post('/mentoring-performances', [MentoringPerformanceController::class, 'store']);
        Route::get('/mentoring-performances/{id}/edit', [MentoringPerformanceController::class, 'edit']);
        Route::put('/mentoring-performances/{id}', [MentoringPerformanceController::class, 'update']);
        Route::delete('/mentoring-performances/{id}', [MentoringPerformanceController::class, 'destroy']);
    });

    Route::prefix('intop')->group(function () {
        Route::get('/integration-summaries', [IntegrationSummaryController::class, 'index']);
        Route::get('/integration-summaries/create', [IntegrationSummaryController::class, 'create']);
        Route::post('/integration-summaries', [IntegrationSummaryController::class, 'store']);
        Route::get('/integration-summaries/{id}/edit', [IntegrationSummaryController::class, 'edit']);
        Route::put('/integration-summaries/{id}', [IntegrationSummaryController::class, 'update']);
        Route::delete('/integration-summaries/{id}', [IntegrationSummaryController::class, 'destroy']);

        Route::get('/service-catalogs', [ServiceCatalogController::class, 'index']);
        Route::get('/service-catalogs/create', [ServiceCatalogController::class, 'create']);
        Route::post('/service-catalogs', [ServiceCatalogController::class, 'store']);
        Route::get('/service-catalogs/{id}/edit', [ServiceCatalogController::class, 'edit']);
        Route::put('/service-catalogs/{id}', [ServiceCatalogController::class, 'update']);
        Route::delete('/service-catalogs/{id}', [ServiceCatalogController::class, 'destroy']);
    });

    Route::prefix('sidebar')->group(function () {
        Route::get('/document-stats', [DocumentStatController::class, 'index']);
        Route::get('/document-stats/create', [DocumentStatController::class, 'create']);
        Route::post('/document-stats', [DocumentStatController::class, 'store']);
        Route::get('/document-stats/{id}/edit', [DocumentStatController::class, 'edit']);
        Route::put('/document-stats/{id}', [DocumentStatController::class, 'update']);
        Route::delete('/document-stats/{id}', [DocumentStatController::class, 'destroy']);

        Route::get('/metrics', [MetricController::class, 'index']);
        Route::get('/metrics/create', [MetricController::class, 'create']);
        Route::post('/metrics', [MetricController::class, 'store']);
        Route::get('/metrics/{id}/edit', [MetricController::class, 'edit']);
        Route::put('/metrics/{id}', [MetricController::class, 'update']);
        Route::delete('/metrics/{id}', [MetricController::class, 'destroy']);

        Route::get('/opd-usages', [OpdUsageController::class, 'index']);
        Route::get('/opd-usages/create', [OpdUsageController::class, 'create']);
        Route::post('/opd-usages', [OpdUsageController::class, 'store']);
        Route::get('/opd-usages/{id}/edit', [OpdUsageController::class, 'edit']);
        Route::put('/opd-usages/{id}', [OpdUsageController::class, 'update']);
        Route::delete('/opd-usages/{id}', [OpdUsageController::class, 'destroy']);
    });
});
