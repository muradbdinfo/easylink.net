<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'type', 'speed_mbps', 'price', 'price_note',
        'features', 'description', 'is_popular', 'is_active', 'order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saving(function (Package $package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->name.'-'.$package->speed_mbps.'mbps');
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
