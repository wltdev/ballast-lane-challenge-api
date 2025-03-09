<?php

use App\Http\Middleware\AuthenticationMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: __DIR__ . '/../routes/api.php'
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('auth', [AuthenticationMiddleware::class]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // Update user milestones hourly
        $schedule->command('app:update-user-milestone')->hourly();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Exception $e, Request $request) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        });
    })->create();
