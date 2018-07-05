<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
        xmlns:dc="http://purl.org/dc/elements/1.1/"
        xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
        xmlns:admin="http://webns.net/mvcb/"
        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">

    <channel>
        <title>{{ $data['title'] }}</title>
        <link>{{ $data['url'] }}/feed</link>
        <description>{{ $data['meta_description'] }}</description>
        <dc:language>ja</dc:language>
        <atom:link rel="self" href="{{ $data['url'] }}/feed" type="application/rss+xml"/>  
        <dc:creator>ogaty</dc:creator>
        <dc:date>{{ \Carbon\Carbon::parse($data['posts'][0]['created_at'])->toAtomString() }}</dc:date>

        @foreach ($data['posts'] as $key => $value)
            <item>
                <title>{{ $value['title'] }}</title>
                <link>{{ $data['url'] }}/blog/posts/{{ $value['slug'] }}</link>
                <description>{{ $value['content_html'] }}</description>
                <dc:creator>ogaty</dc:creator> 
                <dc:date>{{ \Carbon\Carbon::parse($value['updated_at'])->toAtomString() }}</dc:date>
            </item>
        @endforeach
    </channel>
</rss>
