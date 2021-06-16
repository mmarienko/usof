<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author', 'publish_date', 'content'
    ];

    /**
     * The likes that belong to the comment.
     */
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
