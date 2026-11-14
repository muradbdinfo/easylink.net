<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

/**
 * The current EasyLink price list (TURBO … ALPHA, prices in BDT per month, VAT included).
 *
 * Safe on a live site: `php artisan db:seed --class=UpdatePackagesSeeder`
 *  - adds or refreshes the packages below,
 *  - switches every other HOME package off (nothing is deleted, turn one back on in Admin → Packages),
 *  - leaves other corporate packages untouched.
 */
class UpdatePackagesSeeder extends Seeder
{
    private const NOTE = 'VAT included / month';

    public function run(): void
    {
        $social = ['100 Mbps Facebook', '100 Mbps YouTube', 'Uncap BDIX', 'Fixed Bandwidth', '24/7 Support'];

        $home = [
            ['TURBO', 35, 525, $social],
            ['BOOST', 45, 630, ['Unlimited data', 'Free Installation', '24/7 support', 'Free WiFi router', 'Priority support']],
            ['ULTRA', 55, 735, $social],
            ['XPRESS', 80, 840, ['Unlimited data', 'Free Installation', '24/7 support', 'Free WiFi router', 'Gaming optimized']],
            ['PRIME', 120, 1050, $social],
            ['MEGA', 140, 1260, ['Unlimited data', 'Free Installation', 'Dedicated support line', 'Free dual-band router', 'Streaming optimized']],
            ['SUPER', 150, 1575, ['1 Dedicated IP', '100 Mbps YouTube', '100 Mbps Facebook', 'Uncap BDIX', 'Fixed Bandwidth', '24/7 Support']],
            ['HYPER', 220, 2100, $social],
        ];

        $corporate = [
            ['EASYLINK OPTIMA', 50, 4410, ['Fixed Bandwidth', 'Uncap BDIX', '24/7 Support']],
            ['EASYLINK ALPHA', 100, 7875, ['Fixed Bandwidth', 'Uncap BDIX', '24/7 Support']],
        ];

        $keep = [];
        foreach ($home as $i => [$name, $speed, $price, $features]) {
            $keep[] = Package::updateOrCreate(
                ['name' => $name, 'type' => 'home'],
                [
                    'speed_mbps' => $speed,
                    'price' => $price,
                    'price_note' => self::NOTE,
                    'features' => $features,
                    'description' => 'Fiber internet package for home users.',
                    'is_popular' => false,
                    'is_active' => true,
                    'order' => $i + 1,
                ]
            )->id;
        }

        Package::where('type', 'home')->whereNotIn('id', $keep)->update(['is_active' => false]);

        foreach ($corporate as $i => [$name, $speed, $price, $features]) {
            Package::updateOrCreate(
                ['name' => $name, 'type' => 'corporate'],
                [
                    'speed_mbps' => $speed,
                    'price' => $price,
                    'price_note' => self::NOTE,
                    'features' => $features,
                    'description' => 'Business internet package.',
                    'is_popular' => false,
                    'is_active' => true,
                    'order' => 5 + $i,
                ]
            );
        }
    }
}
