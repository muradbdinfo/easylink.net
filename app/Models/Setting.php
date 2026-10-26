<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        return static::allSettings()[$key] ?? $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }

    public static function flush(): void
    {
        Cache::forget('settings');
    }

    public static function allSettings(): array
    {
        $settings = Cache::rememberForever('settings', fn () => static::query()->pluck('value', 'key')->all());

        if (! empty($settings['logo'])) {
            $settings['logo'] = Storage::disk('public')->url($settings['logo']);
        }

        return $settings;
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
        static::deleted(fn () => Cache::forget('settings'));
    }
}
