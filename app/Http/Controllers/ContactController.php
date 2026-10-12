<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact', [
            'packages' => Package::active()->get(['id', 'name', 'type']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
            'type' => 'nullable|in:general,quote,package',
            'package_id' => 'nullable|exists:packages,id',
        ]);

        ContactMessage::create($validated + ['type' => $validated['type'] ?? 'general']);

        return back()->with('success', 'Thank you! Your message has been sent. We will get back to you shortly.');
    }
}
