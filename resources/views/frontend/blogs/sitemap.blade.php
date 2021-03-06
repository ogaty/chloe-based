<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>http://blog.ogatism.com/</loc>
        <lastmod>{{ \Carbon\Carbon::parse($updated)->toAtomString() }}</lastmod>
    </url>
    @foreach ($posts as $key => $value)
    <url>
        <loc>{{ $value->url }}/blog/post/{{ $value->slug }}</loc>
        <lastmod>{{ \Carbon\Carbon::parse($value['updated_at'])->toAtomString() }}</lastmod>
    </url>
    @endforeach
    @foreach ($tags as $key => $value)
    <url>
        <loc>{{ $url }}/blog/?tag={{ $value->tag }}</loc>
        <lastmod>{{ \Carbon\Carbon::parse($value['updated_at'])->toAtomString() }}</lastmod>
    </url>
    @endforeach
    <url>
        <loc>{{ env('APP_URL', 'http://blog.ogatism.com') }}/trycs/index</loc>
        <lastmod>2018-03-30T14:00:00+09:00</lastmod>
    </url>
</urlset>
