<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'permissions' => $request->user()
                    ?->getAllPermissions()
                    ->pluck('name')
                    ->toArray() ?? [],
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'features' => [
                'forms' => config('features.forms'),
                'workflows' => config('features.workflows'),
                'search' => config('features.search'),
            ],
        ];
    }
}
