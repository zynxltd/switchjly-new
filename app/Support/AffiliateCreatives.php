<?php

namespace App\Support;

use App\Models\User;

class AffiliateCreatives
{
    /**
     * @return list<array{key: string, label: string, description: string, url: string}>
     */
    public static function links(User $affiliate): array
    {
        return [
            [
                'key' => 'home',
                'label' => 'Homepage',
                'description' => 'Best all-purpose link for blogs, bios, and email signatures.',
                'url' => $affiliate->referralUrl('/'),
            ],
            [
                'key' => 'compare',
                'label' => 'Start comparing',
                'description' => 'Sends visitors straight into the compare funnel.',
                'url' => $affiliate->referralUrl('/compare/details'),
            ],
            [
                'key' => 'how-it-works',
                'label' => 'How it works',
                'description' => 'Good for audiences who want to understand Brillia first.',
                'url' => $affiliate->referralUrl('/how-it-works'),
            ],
            [
                'key' => 'guides',
                'label' => 'Energy guides',
                'description' => 'Useful for content sites and newsletter “further reading”.',
                'url' => $affiliate->referralUrl('/guides'),
            ],
        ];
    }

    /**
     * @return list<array{title: string, channel: string, body: string}>
     */
    public static function copyBlocks(User $affiliate): array
    {
        $url = $affiliate->referralUrl('/');

        return [
            [
                'title' => 'Short social post',
                'channel' => 'X / LinkedIn / Facebook',
                'body' => "Thinking of switching energy supplier? Compare live UK deals with Brillia — free, fast, and no jargon.\n\n{$url}",
            ],
            [
                'title' => 'Savings-focused post',
                'channel' => 'Social / community groups',
                'body' => "UK bills feeling steep? Brillia compares energy deals in under a minute so you can see what you could save.\n\nCompare free: {$url}",
            ],
            [
                'title' => 'Email / newsletter blurb',
                'channel' => 'Email',
                'body' => "We've teamed up with Brillia, a free UK energy comparison service. Enter a few details and see matching deals from leading suppliers — usually in under a minute.\n\nCompare now: {$url}",
            ],
            [
                'title' => 'Blog CTA paragraph',
                'channel' => 'Website / blog',
                'body' => "Ready to check today's energy deals? Use Brillia to compare tariffs from leading UK suppliers for free. No sign-up required to browse deals — start here: {$url}",
            ],
        ];
    }

    /**
     * @return list<array{name: string, width: int, height: int, html: string}>
     */
    public static function banners(User $affiliate): array
    {
        $url = e($affiliate->referralUrl('/'));
        $logo = e(asset('images/logo-energy-on-dark.svg'));

        return [
            [
                'name' => 'Leaderboard',
                'width' => 728,
                'height' => 90,
                'html' => self::bannerHtml($url, $logo, 728, 90, 'Compare UK energy deals free — see what you could save'),
            ],
            [
                'name' => 'Medium rectangle',
                'width' => 300,
                'height' => 250,
                'html' => self::bannerHtml($url, $logo, 300, 250, 'Free UK energy comparison. Find a better deal in under a minute.'),
            ],
            [
                'name' => 'Wide skyscraper',
                'width' => 160,
                'height' => 600,
                'html' => self::bannerHtml($url, $logo, 160, 600, 'Switch smarter. Compare live UK energy deals with Brillia.'),
            ],
            [
                'name' => 'Mobile banner',
                'width' => 320,
                'height' => 50,
                'html' => self::bannerHtml($url, $logo, 320, 50, 'Compare energy deals free'),
            ],
        ];
    }

    /**
     * @return list<array{label: string, path: string, hint: string}>
     */
    public static function assets(): array
    {
        return [
            [
                'label' => 'Brillia logo (PNG)',
                'path' => asset('images/logo.png'),
                'hint' => 'Parent brand mark. Use on light backgrounds with clear space around it.',
            ],
            [
                'label' => 'Brillia Energy logo (PNG)',
                'path' => asset('images/logo-energy-on-dark.png'),
                'hint' => 'Energy vertical lockup for the comparison site and energy creatives.',
            ],
            [
                'label' => 'Brand kit reference',
                'path' => asset('images/brand-kit.jpg'),
                'hint' => 'Colour and layout reference for on-brand creatives.',
            ],
            [
                'label' => 'Hero image',
                'path' => asset('images/hero-right.png'),
                'hint' => 'Optional lifestyle visual for posts and landing pages.',
            ],
        ];
    }

    protected static function bannerHtml(string $url, string $logo, int $width, int $height, string $message): string
    {
        $tall = $height >= 250 && $width <= 200;
        $compact = $height <= 90;
        $direction = $tall ? 'column' : 'row';
        $align = $tall ? 'flex-start' : 'center';
        $padding = $compact ? '10px 14px' : '18px 16px';
        $logoHeight = $compact ? '22px' : '28px';
        $fontSize = $compact ? '13px' : ($tall ? '16px' : '15px');
        $ctaPad = $compact ? '8px 12px' : '10px 14px';
        $ctaMargin = $tall ? 'margin-top:auto;' : '';

        return <<<HTML
<a href="{$url}" target="_blank" rel="noopener sponsored" style="display:flex;flex-direction:{$direction};align-items:{$align};justify-content:space-between;gap:12px;box-sizing:border-box;width:{$width}px;height:{$height}px;padding:{$padding};background:#0a0a0a;color:#fff;text-decoration:none;font-family:Inter,Arial,sans-serif;">
  <span style="display:flex;flex-direction:column;gap:8px;min-width:0;">
    <img src="{$logo}" alt="brillia energy" style="height:{$logoHeight};width:auto;display:block;">
    <span style="font-size:{$fontSize};font-weight:700;line-height:1.25;color:#fff;">{$message}</span>
  </span>
  <span style="flex-shrink:0;{$ctaMargin}background:#a3ea00;color:#0a0a0a;font-size:12px;font-weight:800;padding:{$ctaPad};border-radius:999px;">Compare</span>
</a>
HTML;
    }
}
