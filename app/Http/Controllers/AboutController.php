<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Partner;
use App\Models\Stat;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('About', [
            'stats' => Stat::active()->get(),
            'partners' => Partner::active()->get(),
            'faqs' => Faq::active()->get(),
        ]);
    }
}
