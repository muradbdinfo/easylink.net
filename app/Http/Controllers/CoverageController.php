<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CoverageController extends Controller
{
    public function index(): Response
    {
        $areas = CoverageArea::active()->orderBy('district')->orderBy('upazilla')->get();

        return Inertia::render('Coverage', [
            'districts' => $areas->pluck('district')->unique()->values(),
            'areas' => $areas,
        ]);
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'district' => 'required|string',
            'upazilla' => 'required|string',
        ]);

        $available = CoverageArea::active()
            ->where('district', $validated['district'])
            ->where('upazilla', $validated['upazilla'])
            ->exists();

        return back()->with('coverageResult', [
            'available' => $available,
            'district' => $validated['district'],
            'upazilla' => $validated['upazilla'],
        ]);
    }
}
