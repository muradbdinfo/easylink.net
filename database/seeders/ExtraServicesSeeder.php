<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Four more services (domain & hosting, IP log server, billing software, consultancy).
 * Safe to run on a live site: `php artisan db:seed --class=ExtraServicesSeeder` only adds or refreshes these four rows.
 * The text is a starting point; edit it in Admin → Services.
 */
class ExtraServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Domain Registration & Web Hosting',
                'icon' => 'globe',
                'category' => 'general',
                'order' => 9,
                'short_description' => 'Register your domain and host your website, email and applications in one place.',
                'description' => <<<'HTML'
<p>Get your business online without juggling several providers. We register and renew your domain name, host your website and set up professional email on your own domain — and our team is one phone call away when you need help.</p>
<h3>What you get</h3>
<ul>
<li>Domain name registration, renewal and transfer</li>
<li>Web hosting for business websites, online shops and web applications</li>
<li>Business email addresses on your own domain</li>
<li>SSL certificate setup, so your site opens securely</li>
<li>Website migration from your old host</li>
<li>Technical support from our local team</li>
</ul>
<h3>Who it is for</h3>
<p>Shops, schools, clinics, offices and anyone who needs a reliable website and email address without managing servers themselves.</p>
HTML,
            ],
            [
                'title' => 'IP Log Server',
                'icon' => 'circle-stack',
                'category' => 'corporate',
                'order' => 10,
                'short_description' => 'Keep subscriber IP and session logs safely stored and easy to search.',
                'description' => <<<'HTML'
<p>Internet service providers are expected to keep records of who used which IP address and when. Our IP log server collects those records from your network, stores them securely and lets you find the answer in seconds when it is asked for.</p>
<h3>What you get</h3>
<ul>
<li>Automatic collection of IP assignment, NAT and session logs</li>
<li>Search by IP address, subscriber, date and time</li>
<li>Long-term storage with regular backups</li>
<li>Reports that can be exported when an authority asks for them</li>
<li>Installation on your hardware or ours, with setup help</li>
<li>Ongoing support from engineers who know ISP networks</li>
</ul>
<h3>Who it is for</h3>
<p>Local ISPs, sub-ISPs, cable operators and corporate networks that need to keep proper access logs.</p>
HTML,
            ],
            [
                'title' => 'Internet Billing Software',
                'icon' => 'banknotes',
                'category' => 'corporate',
                'order' => 11,
                'short_description' => 'Manage customers, packages, invoices and payments from one simple dashboard.',
                'description' => <<<'HTML'
<p>Run your internet business from one place. Our billing software keeps your customers, packages, invoices and payments organised, so you spend less time on spreadsheets and more time growing.</p>
<h3>What you get</h3>
<ul>
<li>Customer records with package, connection and contact details</li>
<li>Automatic monthly invoices and due-date reminders</li>
<li>Payment records for bKash, Nagad, Rocket, bank and cash</li>
<li>Package upgrades, discounts and one-time charges</li>
<li>Collection, due and income reports</li>
<li>Staff accounts with different levels of access</li>
</ul>
<h3>Who it is for</h3>
<p>ISPs and sub-ISPs of every size, from a few hundred to many thousands of subscribers.</p>
HTML,
            ],
            [
                'title' => 'Network Consultancy',
                'icon' => 'light-bulb',
                'category' => 'corporate',
                'order' => 12,
                'short_description' => 'Expert advice to plan, build, secure and fix your network.',
                'description' => <<<'HTML'
<p>Whether you are starting an ISP, growing an office network or chasing a problem nobody can explain, our engineers can look at your network and tell you what to do next, in plain language.</p>
<h3>What we help with</h3>
<ul>
<li>Network design for ISPs, offices, factories and campuses</li>
<li>Planning an upgrade or expansion, including equipment selection</li>
<li>Performance checks and troubleshooting</li>
<li>Security review and hardening</li>
<li>Bandwidth, routing and redundancy planning</li>
<li>Training for your own technical team</li>
</ul>
<h3>How it works</h3>
<p>Tell us about your network, we visit or connect remotely, and you get a clear written recommendation with the next steps.</p>
HTML,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service + ['is_active' => true]);
        }
    }
}
