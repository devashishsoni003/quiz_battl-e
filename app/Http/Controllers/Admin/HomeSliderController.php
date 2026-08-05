<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = HomeSlider::orderBy('sorting', 'asc')->paginate(10);
        return view('admin.pages.home-sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.home-sliders.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_type' => ['required', Rule::in(['none', 'quiz', 'category', 'url'])],
            'link_value' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('home/sliders', $imageName, 'public');
            $data['image'] = $imageName;
        }

        HomeSlider::create($data);

        return redirect()->route('admin.home-sliders.index')->with('success', 'Home Slider created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSlider $home_slider)
    {
        return view('admin.pages.home-sliders.form', ['slider' => $home_slider]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeSlider $home_slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_type' => ['required', Rule::in(['none', 'quiz', 'category', 'url'])],
            'link_value' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($home_slider->image && Storage::disk('public')->exists('home/sliders/' . $home_slider->image)) {
                Storage::disk('public')->delete('home/sliders/' . $home_slider->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('home/sliders', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $home_slider->update($data);

        return redirect()->route('admin.home-sliders.index')->with('success', 'Home Slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSlider $home_slider)
    {
        if ($home_slider->image && Storage::disk('public')->exists('home/sliders/' . $home_slider->image)) {
            Storage::disk('public')->delete('home/sliders/' . $home_slider->image);
        }
        $home_slider->delete();

        return redirect()->route('admin.home-sliders.index')->with('success', 'Home Slider deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(HomeSlider $home_slider)
    {
        $home_slider->status = !$home_slider->status;
        $home_slider->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
