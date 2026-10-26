<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Html;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Settings/Edit', [
            'settings' => Setting::allSettings(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'hotline' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'map_url' => 'nullable|url|max:500',
            'map_embed' => 'nullable|url|max:1000',
            'about_text' => 'nullable|string',
            'facebook_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'remove_logo' => 'nullable|boolean',
        ]);

        $data['about_text'] = Html::clean($data['about_text'] ?? '');

        $logo = $data['logo'] ?? null;
        $removeLogo = $data['remove_logo'] ?? false;
        unset($data['logo'], $data['remove_logo']);

        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        if ($logo) {
            $oldLogo = Setting::query()->where('key', 'logo')->value('value');
            Setting::set('logo', $logo->store('logos', 'public'));
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
        } elseif ($removeLogo) {
            $oldLogo = Setting::query()->where('key', 'logo')->value('value');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            Setting::set('logo', '');
        }

        return back()->with('success', 'Settings updated.');
    }
}
