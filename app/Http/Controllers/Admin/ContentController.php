<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Html;
use App\Support\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ContentController extends Controller
{
    public function edit(Request $request): Response
    {
        $groups = SiteContent::schema();
        $pages = array_column($groups, 'page');
        $active = in_array($request->query('page'), $pages, true) ? $request->query('page') : ($pages[0] ?? null);

        return Inertia::render('Admin/Content/Edit', [
            'groups' => $groups,
            'values' => SiteContent::values(),
            'active' => $active,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $page = $request->input('page');
        $fields = SiteContent::fields($page);
        abort_if($fields === [], 404);

        $request->validate([
            'files.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
        ]);

        // The form sends keys with "." replaced by "|" because Laravel reads dots as nesting.
        $values = $request->input('values', []);
        $files = $request->file('files', []);
        $remove = $request->input('remove', []);
        $enc = fn (string $key) => str_replace('.', '|', $key);

        foreach ($fields as $key => $field) {
            $type = $field['type'] ?? 'text';
            $settingKey = SiteContent::PREFIX.$key;

            if ($type === 'image') {
                $this->updateImage($files[$enc($key)] ?? null, ! empty($remove[$enc($key)]), $key, $settingKey);

                continue;
            }

            if ($type === 'list') {
                $items = collect($values[$enc($key)] ?? [])
                    ->filter(fn ($item) => is_array($item))
                    ->map(fn ($item) => collect($field['fields'])
                        ->mapWithKeys(fn ($sub, $subKey) => [$subKey => (string) ($item[$subKey] ?? '')])
                        ->all())
                    ->filter(fn ($item) => collect($item)->contains(fn ($v) => trim($v) !== ''))
                    ->values()
                    ->all();

                $this->store($settingKey, $items === ($field['default'] ?? []) ? null : json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

                continue;
            }

            if (array_key_exists($enc($key), $values)) {
                $value = trim((string) $values[$enc($key)]);
                $value = $type === 'richtext' ? Html::clean($value) : $value;

                $this->store($settingKey, $value === (string) ($field['default'] ?? '') ? null : $value);
            }
        }

        return back()->with('success', "$page content saved.");
    }

    /** Remove every override of one page so the built-in defaults show again. */
    public function reset(Request $request): RedirectResponse
    {
        $page = $request->input('page');
        $fields = SiteContent::fields($page);
        abort_if($fields === [], 404);

        foreach ($fields as $key => $field) {
            if (($field['type'] ?? 'text') === 'image') {
                $this->deleteStoredImage(SiteContent::raw($key));
            }

            Setting::query()->where('key', SiteContent::PREFIX.$key)->delete();
        }

        Setting::flush();

        return back()->with('success', "$page content reset to defaults.");
    }

    /** Save an override, or drop it when the value equals the built-in default (so default changes still apply). */
    private function store(string $settingKey, ?string $value): void
    {
        if ($value === null) {
            Setting::query()->where('key', $settingKey)->delete();
            Setting::flush();

            return;
        }

        Setting::set($settingKey, $value);
    }

    private function updateImage(?UploadedFile $file, bool $remove, string $key, string $settingKey): void
    {
        $old = SiteContent::raw($key);

        if ($file) {
            $this->deleteStoredImage($old);
            Setting::set($settingKey, $file->store('content', 'public'));
        } elseif ($remove) {
            $this->deleteStoredImage($old);
            Setting::query()->where('key', $settingKey)->delete();
            Setting::flush();
        }
    }

    private function deleteStoredImage(?string $path): void
    {
        if ($path && str_starts_with($path, 'content/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
