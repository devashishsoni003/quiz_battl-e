<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuizLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuizLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quiz_levels = QuizLevel::with('category')->orderBy('sorting', 'asc')->paginate(10);
        return view('admin.pages.quiz-levels.index', compact('quiz_levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.quiz-levels.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'entry_coins' => 'required|numeric|min:0',
            'color' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->storeAs('quiz-levels', $iconName, 'public');
            $data['icon'] = $iconName;
        }

        QuizLevel::create($data);

        return redirect()->route('admin.quiz-levels.index')->with('success', 'Quiz Level created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuizLevel $quiz_level)
    {
        $categories = Category::all();
        return view('admin.pages.quiz-levels.form', compact('quiz_level', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuizLevel $quiz_level)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'entry_coins' => 'required|numeric|min:0',
            'color' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($quiz_level->icon && Storage::disk('public')->exists('quiz-levels/' . $quiz_level->icon)) {
                Storage::disk('public')->delete('quiz-levels/' . $quiz_level->icon);
            }

            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->storeAs('quiz-levels', $iconName, 'public');
            $data['icon'] = $iconName;
        }

        $quiz_level->update($data);

        return redirect()->route('admin.quiz-levels.index')->with('success', 'Quiz Level updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizLevel $quiz_level)
    {
        if ($quiz_level->icon && Storage::disk('public')->exists('quiz-levels/' . $quiz_level->icon)) {
            Storage::disk('public')->delete('quiz-levels/' . $quiz_level->icon);
        }
        
        $quiz_level->delete();

        return redirect()->route('admin.quiz-levels.index')->with('success', 'Quiz Level deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(QuizLevel $quiz_level)
    {
        $quiz_level->status = !$quiz_level->status;
        $quiz_level->save();

        return redirect()->back()->with('success', 'Quiz Level status updated successfully.');
    }
}
