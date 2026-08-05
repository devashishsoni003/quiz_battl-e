<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HomePromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = HomePromotion::orderBy('sorting', 'asc')->paginate(10);
        return view('admin.pages.home-promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.home-promotions.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_type' => ['required', Rule::in(['none', 'quiz', 'category', 'url'])],
            'link_value' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except(['image', 'image_2']);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('home/promotions', $imageName, 'public');
            $data['image'] = $imageName;
        }

        if ($request->hasFile('image_2')) {
            $image2Name = time() . '_2.' . $request->image_2->extension();
            $request->image_2->storeAs('home/promotions', $image2Name, 'public');
            $data['image_2'] = $image2Name;
        }

        HomePromotion::create($data);

        return redirect()->route('admin.home-promotions.index')->with('success', 'Home Promotion created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomePromotion $home_promotion)
    {
        return view('admin.pages.home-promotions.form', ['promotion' => $home_promotion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomePromotion $home_promotion)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'title' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link_type' => ['required', Rule::in(['none', 'quiz', 'category', 'url'])],
            'link_value' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except(['image', 'image_2']);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($home_promotion->image && Storage::disk('public')->exists('home/promotions/' . $home_promotion->image)) {
                Storage::disk('public')->delete('home/promotions/' . $home_promotion->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('home/promotions', $imageName, 'public');
            $data['image'] = $imageName;
        }

        if ($request->hasFile('image_2')) {
            // Delete old image_2
            if ($home_promotion->image_2 && Storage::disk('public')->exists('home/promotions/' . $home_promotion->image_2)) {
                Storage::disk('public')->delete('home/promotions/' . $home_promotion->image_2);
            }

            $image2Name = time() . '_2.' . $request->image_2->extension();
            $request->image_2->storeAs('home/promotions', $image2Name, 'public');
            $data['image_2'] = $image2Name;
        }

        $home_promotion->update($data);

        return redirect()->route('admin.home-promotions.index')->with('success', 'Home Promotion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomePromotion $home_promotion)
    {
        if ($home_promotion->image && Storage::disk('public')->exists('home/promotions/' . $home_promotion->image)) {
            Storage::disk('public')->delete('home/promotions/' . $home_promotion->image);
        }
        if ($home_promotion->image_2 && Storage::disk('public')->exists('home/promotions/' . $home_promotion->image_2)) {
            Storage::disk('public')->delete('home/promotions/' . $home_promotion->image_2);
        }
        $home_promotion->delete();

        return redirect()->route('admin.home-promotions.index')->with('success', 'Home Promotion deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(HomePromotion $home_promotion)
    {
        $home_promotion->status = !$home_promotion->status;
        $home_promotion->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
