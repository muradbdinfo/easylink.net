<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\CoverageArea;
use App\Models\Faq;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Stat;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@easylink.net'],
            [
                'name' => 'EasyLink Admin',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->seedSettings();
        $this->seedSliders();
        $this->seedPackages();
        $this->seedServices();
        $this->seedTestimonials();
        $this->seedPartners();
        $this->seedBlogPosts();
        $this->seedFaqs();
        $this->seedStats();
        $this->seedCoverageAreas();
    }

    private function seedSettings(): void
    {
        $settings = [
            'site_name' => 'EasyLink',
            'tagline' => 'Your reliable internet partner',
            'hotline' => '16999',
            'phone' => '09611-999888',
            'email' => 'support@easylink.net',
            'address' => 'Level-6, Rupayan Trade Center, 114 Kazi Nazrul Islam Avenue, Bijoy Nagar, Dhaka-1000',
            'about_text' => "EasyLink has been delivering dependable fiber-optic internet and corporate connectivity across Bangladesh since 2010. With our own nationwide backbone, a 24/7 Network Operations Center and a skilled technical team, we serve home and corporate customers in all 64 districts.\n\nOur promise is simple: fast, stable internet that just works, backed by people who pick up the phone.",
            'facebook_url' => 'https://facebook.com/easylinkbd',
            'youtube_url' => 'https://youtube.com/@easylinkbd',
            'linkedin_url' => 'https://linkedin.com/company/easylinkbd',
            'instagram_url' => 'https://instagram.com/easylinkbd',
            'footer_text' => 'EasyLink Ltd. — BTRC Approved Nationwide ISP',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }

    private function seedSliders(): void
    {
        $sliders = [
            ['title' => 'High-speed fiber internet across Bangladesh', 'subtitle' => 'Unlimited plans from 10 Mbps to 35 Mbps with free installation.', 'button_text' => 'View packages', 'button_link' => '/packages', 'order' => 1],
            ['title' => 'Corporate connectivity solutions', 'subtitle' => 'Dedicated internet, MPLS, IP VPN and cloud solutions in one place.', 'button_text' => 'Explore solutions', 'button_link' => '/corporate', 'order' => 2],
            ['title' => 'Unlimited speed for gaming and streaming', 'subtitle' => 'Low-latency network for uninterrupted gaming and 4K streaming.', 'button_text' => 'Order now', 'button_link' => '/packages', 'order' => 3],
            ['title' => '24/7 customer support', 'subtitle' => 'Whenever something goes wrong, our team is right beside you.', 'button_text' => 'Contact us', 'button_link' => '/contact', 'order' => 4],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(['order' => $slider['order']], $slider);
        }
    }

    private function seedPackages(): void
    {
        $home = [
            ['name' => 'Bronze', 'speed_mbps' => 10, 'price' => 500, 'is_popular' => false, 'order' => 1, 'features' => ['Unlimited data', 'Free installation', '24/7 support', 'Free router (rental)']],
            ['name' => 'Silver', 'speed_mbps' => 15, 'price' => 600, 'is_popular' => false, 'order' => 2, 'features' => ['Unlimited data', 'Free installation', '24/7 support', 'Free router (rental)']],
            ['name' => 'Gold', 'speed_mbps' => 20, 'price' => 700, 'is_popular' => true, 'order' => 3, 'features' => ['Unlimited data', 'Free installation', '24/7 support', 'Free WiFi router', 'Priority support']],
            ['name' => 'Platinum', 'speed_mbps' => 25, 'price' => 800, 'is_popular' => false, 'order' => 4, 'features' => ['Unlimited data', 'Free installation', '24/7 support', 'Free WiFi router', 'Gaming optimized']],
            ['name' => 'Diamond', 'speed_mbps' => 35, 'price' => 1000, 'is_popular' => false, 'order' => 5, 'features' => ['Unlimited data', 'Free installation', 'Dedicated support line', 'Free dual-band router', 'Streaming optimized']],
        ];

        foreach ($home as $pkg) {
            Package::updateOrCreate(
                ['name' => $pkg['name'], 'type' => 'home'],
                $pkg + ['type' => 'home', 'price_note' => '+ VAT / month', 'description' => 'FTTH fiber internet package for home users.', 'is_active' => true]
            );
        }

        $corporate = [
            ['name' => 'Corporate Starter', 'speed_mbps' => 20, 'price' => 5000, 'order' => 1, 'features' => ['1:1 dedicated bandwidth', '99.9% uptime SLA', '24/7 NOC support', 'Free installation']],
            ['name' => 'Corporate Business', 'speed_mbps' => 50, 'price' => 12000, 'order' => 2, 'features' => ['1:1 dedicated bandwidth', '99.9% uptime SLA', 'Redundant link option', 'Dedicated account manager']],
            ['name' => 'Corporate Enterprise', 'speed_mbps' => 100, 'price' => 22000, 'order' => 3, 'features' => ['1:1 dedicated bandwidth', '99.95% uptime SLA', 'Redundant dual links', 'DDoS protection']],
            ['name' => 'Corporate Ultimate', 'speed_mbps' => 200, 'price' => 40000, 'order' => 4, 'is_popular' => true, 'features' => ['1:1 dedicated bandwidth', '99.99% uptime SLA', 'Redundant dual links', 'DDoS protection', 'Dedicated account manager']],
        ];

        foreach ($corporate as $pkg) {
            Package::updateOrCreate(
                ['name' => $pkg['name'], 'type' => 'corporate'],
                $pkg + ['type' => 'corporate', 'price_note' => '+ VAT / month', 'description' => 'Dedicated Internet Access (DIA) for businesses.', 'is_active' => true]
            );
        }
    }

    private function seedServices(): void
    {
        $services = [
            ['title' => 'Home Internet (FTTH)', 'icon' => 'wifi', 'category' => 'home', 'order' => 1, 'short_description' => 'Fast, unlimited home internet over fiber-optic technology.', 'description' => 'Reliable, low-latency internet delivered over fiber-to-the-home — ideal for gaming, streaming and working from home.'],
            ['title' => 'Corporate Dedicated Internet (DIA)', 'icon' => 'building-office', 'category' => 'corporate', 'order' => 2, 'short_description' => 'Corporate internet with 1:1 dedicated bandwidth and an SLA guarantee.', 'description' => 'Symmetrical dedicated bandwidth for businesses, with uptime SLA and 24/7 NOC monitoring.'],
            ['title' => 'IP Telephony & PABX', 'icon' => 'phone', 'category' => 'corporate', 'order' => 3, 'short_description' => 'Cloud-based IP telephony and virtual PABX solutions.', 'description' => 'Affordable, scalable IP telephony for your office, including multi-branch connectivity.'],
            ['title' => 'Cloud & Data Center Solutions', 'icon' => 'server', 'category' => 'corporate', 'order' => 4, 'short_description' => 'Colocation, cloud hosting and backup solutions.', 'description' => 'Server colocation in a Tier-III data center, cloud compute and disaster recovery solutions.'],
            ['title' => 'Managed WiFi', 'icon' => 'signal', 'category' => 'home', 'order' => 5, 'short_description' => 'Seamless WiFi coverage across your entire home or office.', 'description' => 'Mesh WiFi systems that remove dead zones, with remote monitoring included.'],
            ['title' => 'Network Security', 'icon' => 'shield-check', 'category' => 'corporate', 'order' => 6, 'short_description' => 'Firewall, DDoS protection and network monitoring.', 'description' => 'Enterprise-grade firewall, DDoS mitigation and 24/7 Security Operations Center (SOC) monitoring.'],
            ['title' => 'IPTV', 'icon' => 'tv', 'category' => 'home', 'order' => 7, 'short_description' => 'Local and international channel packages with your internet.', 'description' => 'HD local and international TV channels delivered over your internet connection.'],
            ['title' => 'Bulk SMS & API', 'icon' => 'chat-bubble-left-right', 'category' => 'general', 'order' => 8, 'short_description' => 'Bulk SMS gateway and API for business messaging.', 'description' => 'A dependable bulk SMS gateway for marketing, OTP and notifications.'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title' => $service['title']], $service + ['is_active' => true]);
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            ['name' => 'Rafiqul Islam', 'designation' => 'Home user', 'company' => 'Uttara, Dhaka', 'message' => 'I have been using EasyLink for 3 years. Speed and uptime are both excellent, and customer support always responds quickly.', 'rating' => 5, 'order' => 1],
            ['name' => 'Sadia Akter', 'designation' => 'Freelancer', 'company' => 'Dhanmondi, Dhaka', 'message' => 'I needed a rock-solid connection for video calls and large uploads. EasyLink has been the perfect fit.', 'rating' => 5, 'order' => 2],
            ['name' => 'Mohammad Shahadat Hossain', 'designation' => 'IT Manager', 'company' => 'Bright Textiles Ltd.', 'message' => 'Our dedicated corporate line runs at 99.9%+ uptime, which is critical for our business. The EasyLink NOC team is proactive.', 'rating' => 5, 'order' => 3],
            ['name' => 'Tanvir Ahmed', 'designation' => 'Gamer & streamer', 'company' => 'Mirpur, Dhaka', 'message' => 'Low ping and a stable connection — I have not found a better ISP for gaming and streaming.', 'rating' => 4, 'order' => 4],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['order' => $t['order']], $t + ['is_active' => true]);
        }
    }

    private function seedPartners(): void
    {
        $partners = [
            ['name' => 'Cisco', 'type' => 'partner', 'order' => 1],
            ['name' => 'Huawei', 'type' => 'partner', 'order' => 2],
            ['name' => 'Fortinet', 'type' => 'partner', 'order' => 3],
            ['name' => 'Juniper Networks', 'type' => 'partner', 'order' => 4],
            ['name' => 'Microsoft', 'type' => 'partner', 'order' => 5],
            ['name' => 'Bright Textiles Ltd.', 'type' => 'client', 'order' => 1],
            ['name' => 'Union Bank PLC', 'type' => 'client', 'order' => 2],
            ['name' => 'Padma Group', 'type' => 'client', 'order' => 3],
            ['name' => 'Green Life Hospital', 'type' => 'client', 'order' => 4],
            ['name' => 'Nova Garments', 'type' => 'client', 'order' => 5],
        ];

        foreach ($partners as $p) {
            Partner::updateOrCreate(['name' => $p['name']], $p + ['is_active' => true]);
        }
    }

    private function seedBlogPosts(): void
    {
        $posts = [
            [
                'title' => '5 reasons you need fiber internet',
                'excerpt' => 'Why it is time to switch from copper broadband to fiber-optic internet.',
                'content' => "Fiber-optic internet is far faster and more stable than traditional copper connections. Latency is lower, upload and download speeds are symmetrical, and weather has far less impact.\n\nOn the EasyLink FTTH network you get unlimited plans from 10 Mbps up to 35 Mbps and beyond — ideal for multiple devices, 4K streaming and online gaming.",
                'author_name' => 'EasyLink Team',
            ],
            [
                'title' => 'EasyLink launches new gaming packages',
                'excerpt' => 'Packages specially optimized for gamers and streamers are now live.',
                'content' => "Responding to the gaming community, EasyLink has launched low-latency optimized gaming packages. They include priority routing, direct peering with popular game servers and 24/7 priority support.\n\nCheck whether service is available in your area and order today.",
                'author_name' => 'EasyLink Team',
            ],
            [
                'title' => 'How to choose the best internet plan for your home office',
                'excerpt' => 'A simple guide to picking the right speed and plan for working from home.',
                'content' => "When choosing an internet plan for a home office, three things matter most: upload speed, stability and latency.\n\nFor video conferencing, cloud file sync and VPN use, we recommend a plan with at least 40 Mbps of symmetrical speed.",
                'author_name' => 'EasyLink Team',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::updateOrCreate(['title' => $post['title']], $post + ['is_published' => true, 'published_at' => now()->subDays(rand(1, 30))]);
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            ['question' => 'How long does it take to get a new connection?', 'answer' => 'Within our coverage area, a new connection is usually activated within 24–48 hours.', 'order' => 1],
            ['question' => 'Which areas does EasyLink serve?', 'answer' => 'Use our Coverage page to check service availability by district and thana.', 'order' => 2],
            ['question' => 'How can I pay my bill?', 'answer' => 'You can pay via bKash, Nagad, Rocket, bank transfer and online payment gateways.', 'order' => 3],
            ['question' => 'How much is the installation charge?', 'answer' => 'Installation is completely free on many packages during promotional periods. Contact us for details.', 'order' => 4],
            ['question' => 'Do corporate packages include an SLA guarantee?', 'answer' => 'Yes. All corporate dedicated packages include an uptime SLA and 24/7 NOC monitoring.', 'order' => 5],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['order' => $faq['order']], $faq + ['is_active' => true]);
        }
    }

    private function seedStats(): void
    {
        $stats = [
            ['label' => 'Years of experience', 'value' => '15', 'suffix' => '+', 'icon' => 'calendar', 'order' => 1],
            ['label' => 'Happy customers', 'value' => '50', 'suffix' => 'K+', 'icon' => 'users', 'order' => 2],
            ['label' => 'Districts served', 'value' => '64', 'suffix' => '', 'icon' => 'map', 'order' => 3],
            ['label' => 'Support', 'value' => '24/7', 'suffix' => '', 'icon' => 'headset', 'order' => 4],
        ];

        foreach ($stats as $s) {
            Stat::updateOrCreate(['order' => $s['order']], $s + ['is_active' => true]);
        }
    }

    private function seedCoverageAreas(): void
    {
        $areas = [
            'Dhaka' => ['Gulshan', 'Dhanmondi', 'Mirpur', 'Uttara', 'Banani', 'Mohammadpur', 'Bijoy Nagar', 'Motijheel', 'Badda', 'Rampura'],
            'Chattogram' => ['Panchlaish', 'Kotwali', 'Halishahar', 'Agrabad'],
            'Sylhet' => ['Sylhet Sadar', 'Zindabazar'],
            'Rajshahi' => ['Boalia', 'Motihar'],
            'Khulna' => ['Khulna Sadar', 'Sonadanga'],
            'Cumilla' => ['Cumilla Sadar'],
            'Rangpur' => ['Rangpur Sadar'],
            'Barishal' => ['Barishal Sadar'],
        ];

        foreach ($areas as $district => $upazillas) {
            foreach ($upazillas as $upazilla) {
                CoverageArea::updateOrCreate(compact('district', 'upazilla'), ['is_active' => true]);
            }
        }
    }
}
