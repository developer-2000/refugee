<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('/') }}/sitemap/pages</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>

{{--<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>--}}

{{--<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">--}}

{{--    @foreach ($vacancies as $vacancy)--}}

{{--        <url>--}}

{{--            <loc>{{ url('/') }}/post/{{ $vacancy->alias }}</loc>--}}

{{--            <lastmod>{{ $vacancy->created_at->tz('UTC')->toAtomString() }}</lastmod>--}}

{{--            <changefreq>daily</changefreq>--}}

{{--            <priority>0.8</priority>--}}

{{--        </url>--}}

{{--    @endforeach--}}

{{--</urlset>--}}


{{--    @foreach ($vacancies as $vacancy)--}}
{{--        <url>--}}
{{--            <loc>{{ url('/') }}/post/{{ $vacancy->alias }}</loc>--}}
{{--            <lastmod>{{ $vacancy->created_at->tz('UTC')->toAtomString() }}</lastmod>--}}
{{--            <changefreq>daily</changefreq>--}}
{{--            <priority>0.8</priority>--}}
{{--        </url>--}}
{{--    @endforeach--}}
