<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PackageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Packages/Index', [
            'packages' => Package::orderBy('type')->orderBy('order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Package::create($this->validated($request));

        return back()->with('success', 'Package created.');
    }

    public function update(Request $request, Package $package): RedirectResponse
    {
        $package->update($this->validated($request));

        return back()->with('success', 'Package updated.');
    }

    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();

        return back()->with('success', 'Package deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:home,corporate',
            'speed_mbps' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'price_note' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $data['features'] = array_values(array_filter($data['features'] ?? []));

        return $data;
    }
}
