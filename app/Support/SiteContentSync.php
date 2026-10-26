<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

/**
 * Moves the admin-managed content (packages, services, testimonials, ... and settings) between
 * databases. A deploy only ships code, so content typed into the local admin has to be exported
 * ("php artisan site:export") and is then imported on the live site by a generated migration.
 *
 * Rows are matched on a natural key, so importing is repeatable: it updates existing rows and
 * creates missing ones, and never deletes anything. Users, messages and uploaded files are not synced.
 */
class SiteContentSync
{
    /** table => columns that identify a row */
    public const TABLES = [
        'packages' => ['name', 'type'],
        'services' => ['slug'],
        'testimonials' => ['name', 'company'],
        'partners' => ['name', 'type'],
        'sliders' => ['title'],
        'faqs' => ['question'],
        'stats' => ['label'],
        'coverage_areas' => ['district', 'upazilla'],
        'blog_posts' => ['slug'],
        'settings' => ['key'],
    ];

    /** Columns holding an uploaded picture; only fixed paths (/images/..., https://...) travel, uploads stay where they are. */
    private const IMAGE_COLUMNS = ['image', 'photo', 'logo'];

    private const SKIP = ['id', 'created_at', 'updated_at'];

    public static function export(): array
    {
        $data = [];

        foreach (self::TABLES as $table => $keys) {
            $data[$table] = DB::table($table)->orderBy('id')->get()
                ->map(fn ($row) => self::cleanRow($table, (array) $row))
                ->filter()
                ->values()
                ->all();
        }

        return $data;
    }

    /** @return array<string, array{created:int, updated:int}> */
    public static function import(array $data): array
    {
        $report = [];

        foreach (self::TABLES as $table => $keys) {
            $report[$table] = ['created' => 0, 'updated' => 0];
            $now = now();

            foreach ($data[$table] ?? [] as $row) {
                $where = array_intersect_key($row, array_flip($keys));
                $existing = DB::table($table)->where($where)->first();

                if ($existing) {
                    // never blank out a picture that was uploaded on this server
                    $values = array_filter($row, fn ($value, $column) => ! (in_array($column, self::IMAGE_COLUMNS, true) && $value === null), ARRAY_FILTER_USE_BOTH);
                    DB::table($table)->where('id', $existing->id)->update($values + ['updated_at' => $now]);
                    $report[$table]['updated']++;
                } else {
                    DB::table($table)->insert($row + ['created_at' => $now, 'updated_at' => $now]);
                    $report[$table]['created']++;
                }
            }
        }

        Setting::flush();

        return $report;
    }

    private static function cleanRow(string $table, array $row): ?array
    {
        $row = array_diff_key($row, array_flip(self::SKIP));

        foreach (self::IMAGE_COLUMNS as $column) {
            if (array_key_exists($column, $row) && ! self::isFixedPath($row[$column])) {
                $row[$column] = null;
            }
        }

        if ($table === 'settings') {
            // the logo and page-content pictures are uploads kept in storage/, which is not synced
            if ($row['key'] === 'logo' || (is_string($row['value']) && str_starts_with($row['value'], 'content/'))) {
                return null;
            }
        }

        return $row;
    }

    private static function isFixedPath(?string $value): bool
    {
        return $value !== null && (str_starts_with($value, '/') || str_starts_with($value, 'http'));
    }
}
