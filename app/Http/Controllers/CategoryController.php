<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::All();
    }

    /**
     * Display the category.
     *
     * @param  Category  $category_id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category_id)
    {
        return $category_id;
    }

    /**
     * Display the post categories.
     *
     * @param  Category  $category_id
     * @return \Illuminate\Http\Response
     */
    public function posts(Category $category_id)
    {
        return $category_id->posts;
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'Not work'
            ], Response::HTTP_FORBIDDEN);
        }

        $credentials = $request->only('title', 'content');

        $validator = Validator::make($credentials, [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Category::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Category created'
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $category_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category_id)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'Not work'
            ], Response::HTTP_FORBIDDEN);
        }

        $credentials = $request->only('title', 'content');

        $validator = Validator::make($credentials, [
            'title' => ['string', 'max:255'],
            'content' => ['string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category_id->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Category updated'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the category from storage.
     *
     * @param  Category  $category_id
     * @return \Illuminate\Http\Response
     */
    public function delete(Category $category_id)
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'message' => 'Not work'
            ], Response::HTTP_FORBIDDEN);
        }

        $category_id->posts()->detach();
        $category_id->delete();

        return response()->json([
            'message' => 'Category removed'
        ], Response::HTTP_OK);
    }
}
