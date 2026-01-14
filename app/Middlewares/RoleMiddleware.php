<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class RoleMiddleware
{
    /**
     * Usage in routes: ->middleware('role:admin') or ->middleware('role:admin,sysadmin')
     */
    public function handle(Request $request, ?string $roles = null)
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }

        $role = Auth::user()->role ?? '';
        $allowed = array_filter(array_map('trim', explode(',', (string)$roles)));

        if ($allowed && !in_array($role, $allowed, true)) {
            // If user has no rights — send to home
            app()->route->redirect('/');
        }
    }
}

