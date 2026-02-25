<?php

use Illuminate\Foundation\Application;

$app = Application::configure(basePath: dirname(__DIR__));

// Enable CORS and routing
$app->withRouting(
    web: __DIR__.'/../routes/web.php',
     api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up'
);

// Middleware registration (Laravel 12 uses this style)
$app->withMiddleware(function ($middleware) {
    // Example: global middleware
    // $middleware->push(\App\Http\Middleware\ExampleMiddleware::class);
});

// Exception handling registration
$app->withExceptions(function ($exceptions) {
    // Example: custom exception handling
    // $exceptions->reportable(function (Throwable $e) { ... });
});

return $app->create();