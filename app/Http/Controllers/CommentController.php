<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::All();
    }

     /**
     * Display the comment.
     *
     * @param  Comment  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment_id)
    {
        return $comment_id;
    }

    /**
     * Store a newly created comment in storage.
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

        Comment::create([
            'title' => $title,
            'content' => $content,
            'categories' => $categories,
        ]);

        return response()->json([
            'message' => 'Comment created'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Comment  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment_id)
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
                'message' => 'Http bad request'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($title) {
            $comment_id->title = $title;
        }
        if ($content) {
            $comment_id->content = $content;
        }
        if ($categories) {
            $comment_id->categories = $categories;
        }

        $comment_id->save();

        return response()->json([
            'message' => 'Comment updated'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the comment from storage.
     *
     * @param  Comment  $comment_id
     * @return \Illuminate\Http\Response
     */
    public function delete(Comment $comment_id)
    {
        $comment_id->delete();

        return response()->json([
            'message' => 'Comment removed'
        ], Response::HTTP_OK);
    }
}
