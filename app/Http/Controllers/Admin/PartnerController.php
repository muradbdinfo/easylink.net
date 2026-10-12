<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PartnerController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Partners/Index', [
            'partners' => Partner::orderBy('order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($data);

        return back()->with('success', 'Added.');
    }

    public function update(Request $request, Partner $partner): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($data);

        return back()->with('success', 'Updated.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $partner->delete();

        return back()->with('success', 'Deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:4096',
            'website_url' => 'nullable|string|max:255',
            'type' => 'required|in:client,partner',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
    }
}
