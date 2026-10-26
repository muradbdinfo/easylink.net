<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'website_url', 'type', 'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Uploaded logo, or a bundled logo from public/images/partners that matches the name
     * (e.g. "Bright Textiles Ltd." -> bright-textiles.svg), so new installs are never empty.
     */
    public function getLogoAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }

        $words = preg_split('/[^a-z0-9]+/i', strtolower((string) ($this->attributes['name'] ?? '')), -1, PREG_SPLIT_NO_EMPTY);
        $words = array_values(array_diff($words, ['ltd', 'plc', 'limited', 'inc', 'co']));

        while ($words) {
            $slug = implode('-', $words);

            if (is_file(public_path("images/partners/{$slug}.svg"))) {
                return "/images/partners/{$slug}.svg";
            }

            array_pop($words);
        }

        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
