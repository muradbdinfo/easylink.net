<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Stat;
use App\Models\Testimonial;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Home', [
            'sliders' => Slider::active()->get(),
            'homePackages' => Package::active()->ofType('home')->orderBy('order')->take(4)->get(),
            'services' => Service::active()->take(6)->get(),
            'stats' => Stat::active()->get(),
            'testimonials' => Testimonial::active()->get(),
            'clients' => Partner::active()->ofType('client')->get(),
            'partners' => Partner::active()->ofType('partner')->get(),
            'posts' => BlogPost::published()->take(3)->get(),
        ]);
    }
}
