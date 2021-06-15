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
     * Store a newly created category in storage.
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

        Category::create([
            'title' => $title,
            'content' => $content,
            'categories' => $categories,
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
            $category_id->title = $title;
        }
        if ($content) {
            $category_id->content = $content;
        }
        if ($categories) {
            $category_id->categories = $categories;
        }

        $category_id->save();

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
        $category_id->delete();

        return response()->json([
            'message' => 'Category removed'
        ], Response::HTTP_OK);
    }
}
