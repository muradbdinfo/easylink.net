<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private string $new = "EasyLink Has Been Delivering Dependable Fiber-Optic Internet And Corporate Connectivity Across Bangladesh Since 2010. With Our Own Nationwide Backbone, A 24/7 Network Operations Center And A Skilled Technical Team, We Serve Home And Corporate Customers In All 64 Districts.\n\nOur Promise Is Simple: Fast, Stable Internet That Just Works, Backed By People Who Pick Up The Phone.";

    public function up(): void
    {
        $current = Setting::query()->where('key', 'about_text')->value('value');

        // Only replace the untouched default text (ignoring case / tags / spacing);
        // if the owner already wrote their own text in Admin, leave it alone.
        $norm = fn (?string $s) => mb_strtolower(trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags((string) $s)))));

        if ($current === null || $current === '' || $norm($current) === $norm($this->new)) {
            Setting::set('about_text', $this->new);
        }
    }

    public function down(): void
    {
        //
    }
};
