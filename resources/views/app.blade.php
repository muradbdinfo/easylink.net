<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @php
            $siteName = $page['props']['settings']['site_name'] ?? config('app.name');
            $tagline = $page['props']['settings']['tagline'] ?? null;
            // about_text is HTML from the rich text editor; meta tags need plain text.
            $ogDescription = \Illuminate\Support\Str::limit(
                trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($page['props']['settings']['about_text'] ?? $tagline ?? '')))),
                200
            );
            $ogTitle = $tagline ? "{$siteName} — {$tagline}" : $siteName;
            $ogImage = asset('images/logo-full.png');
        @endphp

        <title inertia>{{ $siteName }}</title>
        <meta name="description" content="{{ $ogDescription }}">
        <link rel="canonical" href="{{ url()->current() }}">
        <link rel="icon" type="image/png" href="/images/favicon.png">

        <!-- Open Graph / Facebook, WhatsApp -->
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ $siteName }}">
        <meta property="og:title" content="{{ $ogTitle }}">
        <meta property="og:description" content="{{ $ogDescription }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:locale" content="en_US">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $ogTitle }}">
        <meta name="twitter:description" content="{{ $ogDescription }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
