<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class FakeAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->header('X-User-ID');

        if (!$userId) {
            return response()->json(['error' => 'X-User-ID header is required'], 401);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'Invalid user ID'], 401);
        }

        // Bind user to request
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
