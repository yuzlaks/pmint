<?php

use MiladRahimi\PhpRouter\Router;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\JsonResponse;
/*
|---------------------------------------------------
| MiladRahimiRouter
|---------------------------------------------------
| 
| PhpRouter is a powerful, lightweight, and very fast 
| HTTP URL router for PHP projects.
| 
|---------------------------------------------------
| source : https://github.com/miladrahimi/phprouter
|---------------------------------------------------
*/

/**
 * Initial Route Project
 */
$router = Router::create();

/**
 * Auth Middleware
 * 
 * Untuk keperluan routes/web.php
 * jika nantinya project ditambahkan fitur login / auth.
 */

class AuthMiddleware{
    public function handle(ServerRequestInterface $request, Closure $next)
    {
        global $auth;
        if ($auth->getUsername()) {
            return $next($request);   
        }

        return errorView('Unauthorized!');

    }
}

/**
 * Get list from routes/web.php
 */

include 'routes/web.php';

/**
 * Execute all routes.
 */

$router->dispatch();