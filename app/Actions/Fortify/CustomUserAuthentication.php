<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\LoginRateLimiter;

class CustomUserAuthentication
{
    protected $limiter;

    public function __construct(LoginRateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function attempt(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            $this->throwFailedAuthenticationException($request);
        }

        if ($user->isInativo()) {
            throw ValidationException::withMessages([
                'email' => 'Sua conta está inativa. Entre em contato com o administrador.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        return $user;
    }

    protected function throwFailedAuthenticationException(Request $request): void
    {
        $this->limiter->hit($request);

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
