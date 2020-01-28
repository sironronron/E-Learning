<?php

namespace App\Http\Controllers\HelpCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpCenter\Category;
use App\Models\HelpCenter\Post;

use Auth;
class PageController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', 3)
            ->get(['icon', 'name', 'slug', 'description']);

        $faqs = Post::where('category_id', 9)
            ->take(6)
            ->get(['title', 'category_id', 'slug', 'id']);

        return response()
            ->json([
                'categories' => $categories,
                'faqs' => $faqs
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

    public function post($categoryId, $postSlug)
    {
        $category = Category::where('id', $categoryId)
            ->where('parent_id', 3)
            ->firstOrFail();

        $post = Post::where('slug', $postSlug)
            ->where('status', 'PUBLISHED')
            ->firstOrFail();

        $categories = Category::where('parent_id', 3)
            ->get(['name', 'slug', 'icon']);

        $related = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->take(5)
            ->get(['title', 'slug', 'id', 'category_id']);

        return response()
            ->json([
                'category' => $category,
                'post' => $post,
                'categories' => $categories,
                'related' => $related
            ]);
    }
}
