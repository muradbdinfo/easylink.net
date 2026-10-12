<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Services/Index', [
            'services' => Service::active()->get(),
        ]);
    }

    public function show(Service $service): Response
    {
        return Inertia::render('Services/Show', [
            'service' => $service,
            'related' => Service::active()->where('category', $service->category)->where('id', '!=', $service->id)->take(3)->get(),
        ]);
    }
}
