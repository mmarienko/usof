<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'desription'
    ];

    /**
     * The post that belong to the category.
     */
    public function posts()
    {
        return $this->belongsToMany('App\Post');
    }
}
