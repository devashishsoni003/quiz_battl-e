<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomePromotion;
use App\Models\HomeSlider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Fetch Home Screen data for the mobile app.
     */
    public function index()
    {
        // 1. Home Sliders
        $home_sliders = HomeSlider::where('status', 1)
            ->orderBy('sorting', 'asc')
            ->get(['id', 'image', 'link_type', 'link_value'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'image' => $item->image_url,
                    'link_type' => $item->link_type,
                    'link_value' => $item->link_value,
                ];
            });

        // 2. Home Promotions
        $home_promotions = HomePromotion::where('status', 1)
            ->orderBy('sorting', 'asc')
            ->get(['id', 'image', 'title', 'description', 'button_text', 'link_type', 'link_value'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'image' => $item->image_url,
                    'title' => $item->title,
                    'description' => $item->description,
                    'button_text' => $item->button_text,
                    'link_type' => $item->link_type,
                    'link_value' => $item->link_value,
                ];
            });

        // 3. Categories
        $categories = Category::where('status', 1)
            ->orderBy('sorting', 'asc')
            ->get(['id', 'image', 'title'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'image' => $item->image_url,
                    'title' => $item->title,
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Home data fetched successfully.',
            'data' => [
                'home_sliders' => $home_sliders,
                'home_promotions' => $home_promotions,
                'categories' => $categories,
            ]
        ], 200);
    }
}
