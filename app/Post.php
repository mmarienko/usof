<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author', 'title', 'publish_date', 'status', 'content', 'categories'
    ];

    /**
     * The categories that belong to the post.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    /**
     * The comments that belong to the post.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * The likes that belong to the post.
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
