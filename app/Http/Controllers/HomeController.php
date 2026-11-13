<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Faq;
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
            'homePackages' => Package::active()->ofType('home')->orderBy('order')->take(6)->get(),
            'heroPackages' => Package::active()->ofType('home')->orderBy('order')->get(['id', 'name', 'speed_mbps', 'price', 'price_note']),
            'services' => Service::active()->take(12)->get(),
            'stats' => Stat::active()->get(),
            'testimonials' => Testimonial::active()->get(),
            'clients' => Partner::active()->ofType('client')->get(),
            'partners' => Partner::active()->ofType('partner')->get(),
            'posts' => BlogPost::published()->take(3)->get(),
            'faqs' => Faq::active()->take(8)->get(),
        ]);
    }
}
