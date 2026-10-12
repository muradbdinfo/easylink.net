<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class CorporateController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Corporate', [
            'services' => Service::active()->where('category', 'corporate')->get(),
            'packages' => Package::active()->ofType('corporate')->get(),
            'clients' => Partner::active()->ofType('client')->get(),
            'testimonials' => Testimonial::active()->get(),
        ]);
    }
}
