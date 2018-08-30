<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = 'tags';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_description',
    ];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag')->withTimestamps();
    }

}
