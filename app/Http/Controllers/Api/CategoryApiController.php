<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::where('status', 1)
            ->orderBy('sorting', 'asc')
            ->paginate(10);

        $mappedCategories = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'image' => $category->image_url,
                'title' => $category->title,
                'sorting' => (int) $category->sorting,
                'status' => (int) $category->status,
            ];
        });

        $paginatedResponse = $categories->toArray();
        $paginatedResponse['data'] = $mappedCategories;

        return response()->json([
            'status' => true,
            'message' => 'Categories fetched successfully.',
            'data' => $paginatedResponse
        ], 200);
    }
}
