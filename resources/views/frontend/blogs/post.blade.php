@extends('frontend.layout')

@section('og-title', $post->title)
@section('twitter-title', $post->title)
@section('og-description', $post->meta_description)
@section('twitter-description', $post->meta_description)
@section('title', \App\Models\Settings::blogTitle().' | '.$post->title)
@if ($post->page_image)
    @section('og-image', url( $post->page_image ))
    @section('twitter-image', url( $post->page_image ))
@endif

@section('content')
    <article>
        <div class="post-detail">
            <div class="container" id="post">
            <div class="">
                @if(Auth::check())
                    <p><a href="{{ route('admin.post.edit', $post->id) }}">edit</a></p>
                @endif

                <div class="">
                    @if ($post->page_image)
                        <div class="text-center">
                            <img src="{{ asset($post->page_image) }}" class="post-hero">
                        </div>
                    @endif
                    <h1 class="post-page-title">{{ $post->title }}</h1>
                    <p class="post-page-meta">
                        <time>{{ \Carbon\Carbon::parse($post->published_at)->diffForHumans() }}</time>
                        @if ($post->tags->count())
                            <br>
                            {!! join(' ', $post->tagLinks()) !!}
                        @endif
                    </p>

                    <div class="post-content">
                        {!! $post->content_html !!}
                    </div>

                    <p class="dts"><span>&#183;</span><span>&#183;</span><span>&#183;</span></p>

                    @include('frontend.shared.author')

                </div>
            </div>
            </div>
        </div>
    </article>

    @include('frontend.shared.paginate-post')
@stop

@section('unique-js')
    <script src="/js/new-frontend.js" charset="utf-8"></script>
@endsection

@section('structure')
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://blog.ogatism.com"
  },
  "headline": "{{ $post->title }}",
  "datePublished": {{ \Carbon\Carbon::parse($post->created_at)->toAtomString() }},
  "dateModified": {{ \Carbon\Carbon::parse($post->updated_at)->toAtomString() }},
  "author": {
    "@type": "Person",
    "name": "ogaty"
  },
   "publisher": {
    "@type": "Organization",
    "name": "ogatism",
    "logo": {
      "@type": "ImageObject",
      "url": "https://ogatism.jp/wp/wp-content/uploads/2015/08/ogatismlogoB1.png"
    }
  },
  "description": "{{ $post->subtitle }}"
}
</script>
@endsection
