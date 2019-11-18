<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpCenter\Category;
use App\Models\HelpCenter\Post;

class PageController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', 3)
            ->get(['icon', 'name', 'slug', 'description']);

        return response()
            ->json([
                'categories' => $categories
            ]);
    }

    public function category($slug)
    {
        $categories = Category::where('parent_id', 3)
            ->get(['name', 'slug', 'icon']);

        $category = Category::where('parent_id', 3)
            ->where('slug', $slug)
            ->firstOrFail();

        $posts = Post::where('category_id', $category->id)
            ->with(['user', 'category'])
            ->where('status', 'PUBLISHED')
            ->get(['title', 'excerpt', 'created_at', 'slug', 'id', 'category_id', 'author_id']);

        return response()
            ->json([
                'categories' => $categories,
                'category' => $category,
                'posts' => $posts
            ]);
    }

    public function post($categorySlug, $postSlug)
    {
        $category = Category::where('slug', $categorySlug)
            ->where('parent_id', 3)
            ->firstOrFail();

        $post = Post::where('slug', $postSlug)
            ->where('status', 'PUBLISHED')
            ->firstOrFail();
        
        $categories = Category::where('parent_id', 3)
            ->get(['name', 'slug', 'icon']);

        return response()
            ->json([
                'category' => $category,
                'post' => $post,
                'categories' => $categories
            ]);
    }
}
