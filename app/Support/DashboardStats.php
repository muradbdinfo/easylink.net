<?php

namespace App\Support;

use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\CoverageArea;
use App\Models\Faq;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/** Numbers and lists shown on the admin dashboard. */
class DashboardStats
{
    private const TREND_DAYS = 30;

    private const TYPES = ['general' => 'General', 'quote' => 'Quote', 'package' => 'Package'];

    public static function all(): array
    {
        $trend = static::trend();
        $messageTotals = ContactMessage::query()
            ->selectRaw("count(*) as total, sum(case when is_read = 0 then 1 else 0 end) as unread, sum(case when type = 'quote' then 1 else 0 end) as quotes")
            ->first();

        return [
            'counts' => [
                'packages' => Package::count(),
                'services' => Service::count(),
                'blogPosts' => BlogPost::count(),
                'messages' => (int) $messageTotals->total,
                'unreadMessages' => (int) $messageTotals->unread,
                'testimonials' => Testimonial::count(),
                'partners' => Partner::count(),
                'sliders' => Slider::count(),
                'faqs' => Faq::count(),
                'coverageAreas' => CoverageArea::count(),
                'quoteRequests' => (int) $messageTotals->quotes,
                'todayMessages' => (int) end($trend)['messages'],
                'weekMessages' => (int) array_sum(array_column(array_slice($trend, -7), 'messages')),
            ],
            'trend' => $trend,
            'byType' => static::byType(),
            'packagesByType' => static::packagesByType(),
            'recentMessages' => static::recentMessages(),
            'latestPosts' => static::latestPosts(),
            'contentHealth' => static::contentHealth(),
            'siteUrl' => url('/'),
        ];
    }

    /** Messages and quote requests per day for the last 30 days, oldest first, zero-filled. */
    private static function trend(): array
    {
        $start = now()->subDays(self::TREND_DAYS - 1)->startOfDay();

        $days = [];
        for ($i = 0; $i < self::TREND_DAYS; $i++) {
            $day = $start->copy()->addDays($i);
            $days[$day->toDateString()] = ['date' => $day->toDateString(), 'label' => $day->format('j M'), 'messages' => 0, 'quotes' => 0];
        }

        ContactMessage::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at', 'type'])
            ->each(function (ContactMessage $message) use (&$days) {
                $date = $message->created_at->toDateString();

                if (isset($days[$date])) {
                    $days[$date]['messages']++;
                    $days[$date]['quotes'] += $message->type === 'quote' ? 1 : 0;
                }
            });

        return array_values($days);
    }

    private static function byType(): array
    {
        $counts = ContactMessage::query()->selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type');

        return collect(self::TYPES)
            ->map(fn (string $label, string $type) => ['type' => $type, 'label' => $label, 'count' => (int) ($counts[$type] ?? 0)])
            ->values()
            ->all();
    }

    private static function packagesByType(): array
    {
        $counts = Package::query()->selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type');

        return ['home' => (int) ($counts['home'] ?? 0), 'corporate' => (int) ($counts['corporate'] ?? 0)];
    }

    private static function recentMessages(): array
    {
        return ContactMessage::query()
            ->with('package:id,name')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn (ContactMessage $m) => [
                'id' => $m->id,
                'name' => $m->name,
                'email' => $m->email,
                'phone' => $m->phone,
                'subject' => $m->subject,
                'message' => mb_strimwidth((string) $m->message, 0, 160, '…'),
                'type' => $m->type,
                'is_read' => (bool) $m->is_read,
                'created_at' => $m->created_at->toIso8601String(),
                'time_ago' => $m->created_at->diffForHumans(),
                'package_name' => $m->package?->name,
            ])
            ->all();
    }

    private static function latestPosts(): array
    {
        return BlogPost::query()
            ->latest()
            ->take(4)
            ->get()
            ->map(fn (BlogPost $p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'is_published' => (bool) $p->is_published,
                'published_at' => $p->published_at?->toIso8601String(),
                'created_at' => $p->created_at->toIso8601String(),
            ])
            ->all();
    }

    /** Setup checklist: what is already filled in and where to fix the rest. */
    private static function contentHealth(): array
    {
        $settings = Setting::allSettings();
        $filled = fn (string $key) => trim((string) ($settings[$key] ?? '')) !== '';

        $items = [
            ['contact', 'Contact details & map', $filled('address') && $filled('phone') && $filled('map_url'), 'Address, phone and Google Maps link', 'admin.settings.edit'],
            ['logo', 'Website logo', $filled('logo'), 'Upload your logo in Settings', 'admin.settings.edit'],
            ['testimonials', 'Customer testimonials', Testimonial::count() >= 3, 'Add at least 3 testimonials', 'admin.testimonials.index'],
            ['blog', 'Blog posts', BlogPost::where('is_published', true)->count() >= 3, 'Publish at least 3 posts', 'admin.blog-posts.index'],
            ['slider', 'Own slider picture', Slider::whereNotNull('image')->exists(), 'Upload a picture to a slider', 'admin.sliders.index'],
            ['social', 'Social links', $filled('facebook_url'), 'Add your Facebook page link', 'admin.settings.edit'],
            ['content', 'Page content customised', collect($settings)->keys()->contains(fn ($key) => str_starts_with($key, SiteContent::PREFIX)), 'Edit texts and pictures of your pages', 'admin.content.edit'],
            ['partners', 'Clients & partners', Partner::count() > 0, 'Add client or partner logos', 'admin.partners.index'],
        ];

        return array_map(fn (array $i) => ['key' => $i[0], 'label' => $i[1], 'done' => (bool) $i[2], 'hint' => $i[3], 'route' => $i[4]], $items);
    }
}
