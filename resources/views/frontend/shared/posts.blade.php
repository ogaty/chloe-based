@foreach ($posts as $post)
    <div class="post-preview">
        <h2 class="post-title">
            <a href="{{ $post->url($tag) }}">{{ $post->title }}</a>
        </h2>
        <p class="post-meta">
            {{ $post->published_at->diffForHumans() }}
            <br>
            @unless( $post->tags->isEmpty())
                {!! implode(' ', $post->tagLinks()) !!}
            @endunless
        </p>
        <p class="postSubtitle">
            {{ str_limit($post->subtitle, config('blog.frontend_trim_width')) }}
        </p>
        <p class=""><a href="{{ $post->url($tag) }}" class="read-more">READ MORE...</a></p>
    </div>
    <hr>
@endforeach
