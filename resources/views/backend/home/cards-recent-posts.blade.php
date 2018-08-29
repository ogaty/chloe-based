<div class="card half">
    <div class="card__header">
        <h2>Recent Activity
            <small>Last 4 published blog posts:</small>
        </h2>
    </div>

    <div class="recent-activity">
        @foreach ($data['recentPosts'] as $post)
            <a href="{!! route('admin.post.edit', $post->id) !!}">{{ $post->title }}</a> <small>{{ $post->created_at->format('M d, Y') }} at {{ $post->created_at->format('g:i A') }}</small>
            <hr>
        @endforeach
    </div>
</div>
