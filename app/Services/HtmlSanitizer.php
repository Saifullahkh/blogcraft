<?php

namespace App\Services;

class HtmlSanitizer
{
    private string $allowedTags = '<p><br><strong><b><em><i><ul><ol><li><blockquote><a><h2><h3><h4><img><figure><figcaption><pre><code>';

    public function clean(string $html): string
    {
        $html = strip_tags($html, $this->allowedTags);
        $html = preg_replace('/\son\w+="[^"]*"/i', '', $html) ?? $html;
        $html = preg_replace("/\son\w+='[^']*'/i", '', $html) ?? $html;
        $html = preg_replace('/javascript:/i', '', $html) ?? $html;

        return trim($html);
    }
}
