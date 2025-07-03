<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SaleManagerMiddleware;
use App\Http\Middleware\SaleOfficerMiddleware;
use App\Http\Middleware\CustomerServiceMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        using: function (){
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->group(base_path('routes/auth.php'));

        Route::middleware(['web', 'admin_group'])
            ->prefix('admin')
            ->name('admin.')
            ->group(base_path('routes/admin.php'));

        Route::middleware(['web', 'customer_service_group'])
            ->prefix('customer_service')
            ->name('customer_service.')
            ->group(base_path('routes/customer-service.php'));

        Route::middleware(['web', 'sale_manager_group'])
            ->prefix('sale_manager')
            ->name('sale_manager.')
            ->group(base_path('routes/sale-manager.php'));

        Route::middleware(['web', 'sale_officer_group'])
            ->prefix('sale_officer')
            ->name('sale_officer.')
            ->group(base_path('routes/sale-officer.php'));
    }

    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->appendToGroup('admin_group', [
            AdminMiddleware::class,
        ]);
    
        $middleware->appendToGroup('sale_manager_group', [
            SaleManagerMiddleware::class,
        ]);
    
        $middleware->appendToGroup('sale_officer_group', [
            SaleOfficerMiddleware::class,
        ]);
    
        $middleware->appendToGroup('customer_service_group', [
            CustomerServiceMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
