<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StatController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Stats/Index', [
            'stats' => Stat::orderBy('order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Stat::create($this->validated($request));

        return back()->with('success', 'Stat added.');
    }

    public function update(Request $request, Stat $stat): RedirectResponse
    {
        $stat->update($this->validated($request));

        return back()->with('success', 'Stat updated.');
    }

    public function destroy(Stat $stat): RedirectResponse
    {
        $stat->delete();

        return back()->with('success', 'Stat deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:50',
            'suffix' => 'nullable|string|max:20',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);
    }
}
