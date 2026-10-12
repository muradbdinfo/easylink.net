<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoverageArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CoverageAreaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/CoverageAreas/Index', [
            'areas' => CoverageArea::orderBy('district')->orderBy('upazilla')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        CoverageArea::create($this->validated($request));

        return back()->with('success', 'Area added.');
    }

    public function update(Request $request, CoverageArea $coverageArea): RedirectResponse
    {
        $coverageArea->update($this->validated($request));

        return back()->with('success', 'Area updated.');
    }

    public function destroy(CoverageArea $coverageArea): RedirectResponse
    {
        $coverageArea->delete();

        return back()->with('success', 'Area deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'district' => 'required|string|max:100',
            'upazilla' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);
    }
}
