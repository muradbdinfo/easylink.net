<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\Package;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'counts' => [
                'packages' => Package::count(),
                'services' => Service::count(),
                'blogPosts' => BlogPost::count(),
                'messages' => ContactMessage::count(),
                'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            ],
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }
}
