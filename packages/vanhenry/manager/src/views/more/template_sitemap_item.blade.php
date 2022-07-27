<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
@foreach($listItems as $item)
	@foreach(Config::get('app.locales') as $locale => $value)
	<url>
		<loc>
        @php
            $language = $locale.'_link';
        @endphp
		@if($locale != Config::get('app.locale_origin'))
			{{ url('/')."/$locale/".$item->table.'/'.$item->$language}}
		@else
			{{ url('/').'/'.$item->table.'/'.$item->$language}}
		@endif
		</loc>
		<lastmod>{{date_create_from_format("Y-m-d H:i:s",$item->created_at)->format("Y-m-d\TH:i:sP")}}</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.9</priority>
	</url>
	@endforeach
@endforeach
</urlset>
