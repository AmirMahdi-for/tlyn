<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    /**
     * The application's route middleware.
     *
     * @var array<string, class-string>
     */
    protected $routeMiddleware = [
        'fake-auth' => \App\Http\Middleware\FakeAuthMiddleware::class,
    ];
}
