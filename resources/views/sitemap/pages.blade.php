<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
        <link rel="alternate" hreflang="uk" href="{{ url('/') }}/uk" />
        <link rel="alternate" hreflang="ru" href="{{ url('/') }}/ru" />
        <link rel="alternate" hreflang="ro" href="{{ url('/') }}/ro" />
        <link rel="alternate" hreflang="en" href="{{ url('/') }}" />
    </url>

    <url>
        <loc>{{ url('/') }}/show-charity</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <link rel="alternate" hreflang="uk" href="{{ url('/') }}/uk/show-charity" />
        <link rel="alternate" hreflang="ru" href="{{ url('/') }}/ru/show-charity" />
        <link rel="alternate" hreflang="ro" href="{{ url('/') }}/ro/show-charity" />
        <link rel="alternate" hreflang="en" href="{{ url('/') }}/show-charity" />
    </url>

    <url>
        <loc>{{ url('/') }}/about-us</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <link rel="alternate" hreflang="uk" href="{{ url('/') }}/uk/about-us" />
        <link rel="alternate" hreflang="ru" href="{{ url('/') }}/ru/about-us" />
        <link rel="alternate" hreflang="ro" href="{{ url('/') }}/ro/about-us" />
        <link rel="alternate" hreflang="en" href="{{ url('/') }}/about-us" />
    </url>

    <url>
        <loc>{{ url('/') }}/feedback</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <link rel="alternate" hreflang="uk" href="{{ url('/') }}/uk/feedback" />
        <link rel="alternate" hreflang="ru" href="{{ url('/') }}/ru/feedback" />
        <link rel="alternate" hreflang="ro" href="{{ url('/') }}/ro/feedback" />
        <link rel="alternate" hreflang="en" href="{{ url('/') }}/feedback" />
    </url>

    <url>
        <loc>{{ url('/') }}/cookie-police</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <link rel="alternate" hreflang="uk" href="{{ url('/') }}/uk/cookie-police" />
        <link rel="alternate" hreflang="ru" href="{{ url('/') }}/ru/cookie-police" />
        <link rel="alternate" hreflang="ro" href="{{ url('/') }}/ro/cookie-police" />
        <link rel="alternate" hreflang="en" href="{{ url('/') }}/cookie-police" />
    </url>

    <url>
        <loc>{{ url('/') }}/terms-use</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
        <link rel="alternate" hreflang="uk" href="{{ url('/') }}/uk/terms-use" />
        <link rel="alternate" hreflang="ru" href="{{ url('/') }}/ru/terms-use" />
        <link rel="alternate" hreflang="ro" href="{{ url('/') }}/ro/terms-use" />
        <link rel="alternate" hreflang="en" href="{{ url('/') }}/terms-use" />
    </url>

</urlset>

