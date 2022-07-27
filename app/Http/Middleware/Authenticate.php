<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware {
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request) {
        if (!$request->expectsJson() && str_contains($request->route()->getPrefix(), 'manager')) {
            return route('manager.login');
        }

        if (!$request->expectsJson() && str_contains($request->route()->getPrefix(), 'client')) {
            return route('client.login');
        }
    }
}
