<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

use App\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function store(Request $request)
    {
        $credentials = $request->only('title', 'content', 'categories');

        $validator = Validator::make($credentials, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'categories' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $title = $request->title;
        $content = $request->content;
        $categories = $request->categories;

        Post::create([
            'title' => $title,
            'content' => $content,
            'categories' => $categories,
        ]);

        return response()->json([
            'message' => 'Post created.'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Post $post)
    {
        $credentials = $request->only('title', 'content', 'categories');

        $validator = Validator::make($credentials, [
            'title' => ['string', 'max:255'],
            'content' => ['string'],
            'categories' => ['string']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $title = $request->title;
        $content = $request->content;
        $categories = $request->categories;

        if (!$title && !$content && !$categories) {
            return response()->json([
                'message' => 'Http bad request.'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($title) {
            $post->title = $title;
        }
        if ($content) {
            $post->content = $content;
        }
        if ($categories) {
            $post->categories = $categories;
        }

        $post->save();

        return response()->json([
            'message' => 'Post updated.'
        ], Response::HTTP_OK);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post removed.'
        ], Response::HTTP_OK);
    }
}
