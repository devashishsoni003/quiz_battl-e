<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuizLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizLevelApiController extends Controller
{
    /**
     * Fetch Quiz Levels by Category ID.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $categoryId = $request->input('category_id');

        $quizLevels = QuizLevel::where('category_id', $categoryId)
            ->where('status', 1)
            ->orderBy('sorting', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category_id' => $item->category_id,
                    'title' => $item->title,
                    'icon' => $item->icon_url,
                    'entry_coins' => (int) $item->entry_coins,
                    'color' => $item->color,
                    'sorting' => (int) $item->sorting,
                    'status' => (int) $item->status,
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Quiz levels fetched successfully.',
            'data' => $quizLevels
        ], 200);
    }
}
