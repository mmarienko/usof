<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $credentials = $request->only('sortby', 'filter');

        $validator = Validator::make($credentials, [
            'sortby' => ['string', 'max:255', 'in:ASC,DESC'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        };

        switch ($request->sortby) {
            case 'ASC':
                return Post::orderBy('created_at')->paginate(10);
                break;
            case 'DESC':
                return Post::orderByDesc('created_at')->paginate(10);
                break;
            default:
                return Post::withCount('likes')->orderByDesc('likes_count')->paginate(10);
        }
    }

    /**
     * Display the post.
     *
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post_id)
    {
        return $post_id;
    }

    /**
     * Display the post categories.
     *
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function categories(Post $post_id)
    {
        return $post_id->categories;
    }

    /**
     * Display the post comments.
     *
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function comments(Post $post_id)
    {
        return $post_id->comments;
    }

    /**
     * Display the post likes.
     *
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function likes(Post $post_id)
    {
        return $post_id->likes;
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('title', 'content', 'categories');

        $validator = Validator::make($credentials, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'categories' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        };

        $post_id = Post::create([
            'author' => auth()->user()->full_name,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $post_id->categories()->attach($request->categories);

        return response()->json([
            'message' => 'Post created'
        ], Response::HTTP_CREATED);
    }

    /**
     * Store a newly created comment of post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function comment(Post $post_id, Request $request)
    {
        $credentials = $request->only('content');

        $validator = Validator::make($credentials, [
            'content' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post_id->comments()->create([
            'author' => auth()->user()->full_name,
            'content' => $request->content,
        ]);


        return response()->json([
            'message' => 'Comment created'
        ], Response::HTTP_CREATED);
    }

    /**
     * Store a newly created like of post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function like(Post $post_id, Request $request)
    {
        $credentials = $request->only('type');

        $validator = Validator::make($credentials, [
            'type' => ['required', 'string', 'in:like,dislike']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post_id->likes()->create([
            'author' => auth()->user()->full_name,
            'type' => $request->type,
        ]);


        return response()->json([
            'message' => 'Like created'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post_id)
    {
        $credentials = $request->only('title', 'content', 'categories');

        $validator = Validator::make($credentials, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'categories' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post_id->categories()->detach();

        $post_id->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        $post_id->categories()->attach($request->categories);

        return response()->json([
            'message' => 'Post updated'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the post from storage.
     *
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function delete(Post $post_id)
    {
        $post_id->categories()->detach();
        $post_id->comments()->delete();
        $post_id->likes()->delete();
        $post_id->delete();

        return response()->json([
            'message' => 'Post removed'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the likes of post from storage.
     *
     * @param  Post  $post_id
     * @return \Illuminate\Http\Response
     */
    public function deleteLike(Post $post_id)
    {
        $post_id->likes()->delete();

        return response()->json([
            'message' => 'Likes removed'
        ], Response::HTTP_OK);
    }
}
