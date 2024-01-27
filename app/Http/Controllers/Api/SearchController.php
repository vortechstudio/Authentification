<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Social\Event;
use App\Models\Social\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');

        $results = collect();

        // Recherche sur les blogs
        $results->push([
            "blogs" => Blog::where('published', true)
                ->whereHas('cercles', function ($query) use ($category) {
                    $query->where('cercles.name', 'like', "%$category%");
                })
                ->where('title', 'like', "%$query%")
                ->orWhere('contenue', 'like', "%$query%")
                ->paginate(5)
        ]);

        // Recherche sur les posts
        $results->push([
            "posts" => Post::whereHas('cercles', function ($query) use ($category) {
                    $query->where('cercles.name', 'like', "%$category%");
                })
                ->where('title', 'like', "%$query%")
                ->orWhere('content', 'like', "%$query%")
                ->paginate(5)
        ]);

        // Recherche sur les events
        $results->push([
            "events" => Event::whereHas('cercles', function ($query) use ($category) {
                    $query->where('cercles.name', 'like', "%$category%");
                })
                ->where('title', 'like', "%$query%")
                ->orWhere('synopsis', 'like', "%$query%")
                ->orWhere('content', 'like', "%$query%")
                ->paginate(5)
        ]);

        // Recherche sur les users

        $results->push([
            "users" => User::where('name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->paginate(5)
        ]);



        return response()->json($results);
    }
}
