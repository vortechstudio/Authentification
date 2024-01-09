<?php

namespace App\Http\Controllers\Api\Social;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function all()
    {
        $query = Blog::with('cercles');
        return response()->json($query->get(), 200);
    }

    public function search(Request $request)
    {
        $validFields = ['title', 'category', 'subcategory', 'published', 'promote'];
        $query = Blog::with('cercles');

        if ($request->has('search')) {
            foreach ($request->get('search') as $field => $value) {
                if (in_array($field, $validFields) && !empty($value)) {
                    $query->where($field, 'LIKE', '%' . $value . '%');
                } else {
                    return response()->json(['error' => 'Invalid search field'], 400);
                }
            }
        }

        if($request->has('limit')) {
            $query->limit($request->get('limit'));
        }

        $articles = $query->get();
        return response()->json($articles, 200);

    }

    public function info($id)
    {
        $query = Blog::with('cercles')->find($id);
        if (!$query) {
            return response()->json(['error' => 'Article not found'], 404);
        } else {
            return response()->json($query, 200);
        }
    }
}
