<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

/**
 * Admin-editable page content.
 *
 * Every schema file in config/site_content/*.php describes one page group:
 *   return ['page' => 'Home', 'sections' => [['title' => 'Hero', 'fields' => ['home.hero.title' => [...]]]]];
 *
 * A field is ['label' => ..., 'type' => text|textarea|url|image|list, 'default' => ..., 'help' => ...].
 * A list field also has 'fields' => [subKey => ['label' => ..., 'type' => text|textarea|url|icon]].
 * Overrides live in the settings table as "content.<key>" (lists as JSON); the default is used when none exists.
 */
class SiteContent
{
    public const PREFIX = 'content.';

    public static function schema(): array
    {
        $groups = [];

        foreach (glob(config_path('site_content/*.php')) ?: [] as $file) {
            $group = require $file;
            $page = $group['page'];

            if (isset($groups[$page])) {
                $groups[$page]['sections'] = [...$groups[$page]['sections'], ...$group['sections']];
            } else {
                $groups[$page] = $group;
            }
        }

        return array_values($groups);
    }

    /** @return array<string, array> key => field definition */
    public static function fields(?string $page = null): array
    {
        $fields = [];

        foreach (static::schema() as $group) {
            if ($page !== null && $group['page'] !== $page) {
                continue;
            }

            foreach ($group['sections'] as $section) {
                foreach ($section['fields'] as $key => $field) {
                    $fields[$key] = $field;
                }
            }
        }

        return $fields;
    }

    /** Resolved values (defaults + overrides) for every field. Images are returned as URLs. */
    public static function values(): array
    {
        $stored = Setting::allSettings();
        $values = [];

        foreach (static::fields() as $key => $field) {
            $raw = $stored[static::PREFIX.$key] ?? null;
            $type = $field['type'] ?? 'text';

            if ($raw === null) {
                $value = $field['default'] ?? ($type === 'list' ? [] : '');
            } elseif ($type === 'list') {
                $value = json_decode($raw, true);
                $value = is_array($value) ? $value : ($field['default'] ?? []);
            } else {
                $value = $raw;
            }

            if ($type === 'image' && is_string($value) && $value !== '') {
                $value = static::imageUrl($value);
            }

            $values[$key] = $value;
        }

        return $values;
    }

    public static function imageUrl(string $path): string
    {
        if (str_starts_with($path, '/') || str_starts_with($path, 'http')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    public static function raw(string $key): ?string
    {
        return Setting::query()->where('key', static::PREFIX.$key)->value('value');
    }
}
