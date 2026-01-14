<?php

namespace Middlewares;

use Exception;
use Src\Request;
use Src\Session;

class CSRFMiddleware
{
    public function handle(Request $request): void
    {
        // Генерируем CSRF токен если его нет
        if (empty(Session::get('csrf_token'))) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }

        if ($request->method !== 'POST') {
            return;
        }

        if (empty($request->get('csrf_token')) ||
            $request->get('csrf_token') !== Session::get('csrf_token')) {
            throw new Exception('Request not authorized');
        }
    }
}