<?php

namespace App\Support;

class Html
{
    private const ALLOWED = '<p><br><strong><b><em><i><u><s><ul><ol><li><a><h2><h3><h4><blockquote><img><table><thead><tbody><tr><th><td><hr><span><div><figure><figcaption><iframe><pre><code>';

    /** Strip scripts and event handlers from rich text written in the admin editor. */
    public static function clean(?string $html): string
    {
        $html = strip_tags((string) $html, self::ALLOWED);
        $html = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1=$2#$2', $html);

        return $html;
    }
}
