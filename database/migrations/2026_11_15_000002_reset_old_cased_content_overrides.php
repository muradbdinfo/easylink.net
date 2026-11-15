<?php

use App\Models\Setting;
use App\Support\SiteContent;
use Illuminate\Database\Migrations\Migration;

/**
 * Saved Admin content overrides the defaults in config/site_content, so the Title Case defaults never reached
 * the live site for fields that had been saved earlier. This removes a saved override ONLY when it says the
 * same thing as the current default apart from capitalisation / spacing (e.g. "Browse movies", "DhakaMovies").
 * Text the owner really rewrote is left untouched.
 */
return new class extends Migration
{
    public function up(): void
    {
        $norm = fn ($v) => mb_strtolower(preg_replace('/\s+/', '', html_entity_decode(strip_tags((string) $v))));

        foreach (SiteContent::fields() as $key => $field) {
            $type = $field['type'] ?? 'text';
            $storedKey = SiteContent::PREFIX.$key;
            $raw = Setting::query()->where('key', $storedKey)->value('value');

            if ($raw === null || ! array_key_exists('default', $field) || in_array($type, ['image', 'url'], true)) {
                continue;
            }

            if ($type === 'list') {
                $stored = json_decode($raw, true);
                $default = $field['default'];

                if (! is_array($stored) || ! is_array($default) || count($stored) !== count($default)) {
                    continue;
                }

                $same = true;
                foreach ($default as $i => $row) {
                    foreach (['title', 'desc', 'cta', 'question', 'answer', 'label', 'text', 'name', 'role'] as $col) {
                        if (isset($row[$col]) && $norm($stored[$i][$col] ?? null) !== $norm($row[$col])) {
                            $same = false;
                            break 2;
                        }
                    }
                }

                if (! $same) {
                    continue;
                }
            } elseif ($norm($raw) !== $norm($field['default'])) {
                continue;
            }

            Setting::query()->where('key', $storedKey)->delete();
        }

        Setting::flush();
    }

    public function down(): void
    {
        //
    }
};
