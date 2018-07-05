<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'canvas_posts';
    protected $dates = ['published_at'];

    public function url(Tag $tag = null)
    {
        $params = [];
        $params['slug'] = $this->slug;
        $params['tag'] = $tag ? $tag->tag : null;

        return false;
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
            $url = '';
            $return[] = '<a href="'.url($url).'">#'.e($tag).'</a>&nbsp;';
        }

        return $return;
    }
}
