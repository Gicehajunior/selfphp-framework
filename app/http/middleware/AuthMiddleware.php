<?php

namespace App\Http\Middlewares;

use SelfPhp\Auth;
use SelfPhp\Request; 

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request 
     * @return mixed
     * @throws \RuntimeException
     */
    public function handle(Request $request)
    {
        if (!$this->isAuthEnabled()) {
            throw new \RuntimeException('Authentication is disabled in environment configuration.');
        }

        if (!$this->isAuthenticated()) {
            return $this->unauthenticatedResponse();
        }

        return true;
    }

    /**
     * Check if authentication is enabled.
     */
    protected function isAuthEnabled(): bool
    {
        return (bool) env('AUTH');
    }

    /**
     * Determine if user is authenticated.
     */
    protected function isAuthenticated(): bool
    {
        return Auth::auth() === true;
    }

    /**
     * Handle unauthenticated users.
     */
    protected function unauthenticatedResponse()
    {
        $loginPage = config('AUTHPAGE');

        if (empty($loginPage)) {
            throw new \RuntimeException('Login page is not configured.');
        }

        return route($loginPage, [
            'status'  => 'error',
            'message' => 'Authentication required.'
        ]);
    }
}