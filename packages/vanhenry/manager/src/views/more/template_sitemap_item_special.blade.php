<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    @foreach($listItems as $item)
        <url>
            <loc>{{ url()->to($item['slug'])}}</loc>
            <lastmod>{{$item['lastmod']->format("Y-m-d\TH:i:sP")}}</lastmod>
            <changefreq>{{$item['changefreq'] ?? 'never'}}</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>
    