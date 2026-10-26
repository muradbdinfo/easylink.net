<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Support\SiteContent;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'settings' => array_filter(Setting::allSettings(), fn ($key) => ! str_starts_with($key, SiteContent::PREFIX), ARRAY_FILTER_USE_KEY),
            'content' => fn () => SiteContent::values(),
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'coverageResult' => fn () => $request->session()->get('coverageResult'),
            ],
        ];
    }
}
