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
     * The category that belong to the post.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Tag');
    }
}
