<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    protected $table = 'posts';
    protected $dates = ['published_at'];

    public function url(Tag $tag = null)
    {
        $params = [];
        $params['slug'] = $this->slug;
        $params['tag'] = $tag ? $tag->tag : null;

        return route('front.post', array_filter($params));
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'canvas_post_tag')->withTimestamps();
    }

    public function tagLinks()
    {
        $tags = $this->tags()->pluck('tag');
        $return = [];
        foreach ($tags as $tag) {
            $return[] = '<a href="/?tag='.$tag.'">#'.e($tag).'</a>&nbsp;';
        }

        return $return;
    }

    public function newerPost(Tag $tag = null)
    {
        $query =
        static::where('published_at', '>', $this->published_at)
            ->where('published_at', '<=', Carbon::now())
            ->where('is_published', 1)
            ->orderBy('published_at', 'asc');
        if ($tag) {
            $query = $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag', '=', $tag->tag);
            });
        }

        return $query->first();
    }

    public function olderPost(Tag $tag = null)
    {
        $query =
        static::where('published_at', '<', $this->published_at)
            ->where('is_published', 1)
            ->orderBy('published_at', 'desc');
        if ($tag) {
            $query = $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag', '=', $tag->tag);
            });
        }

        return $query->first();
    }

    public static function getAuthor($id)
    {
        return User::where('id', $id)->pluck('display_name')->first();
    }

}
