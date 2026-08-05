<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $frames = Frame::orderBy('sorting', 'asc')->paginate(10);
        return view('admin.pages.frames.index', compact('frames'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.frames.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'required_level' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('frames', $imageName, 'public');
            $data['image'] = $imageName;
        }

        Frame::create($data);

        return redirect()->route('admin.frames.index')->with('success', 'Frame created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Frame $frame)
    {
        return view('admin.pages.frames.form', compact('frame'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Frame $frame)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'required_level' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'sorting' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($frame->image && Storage::disk('public')->exists('frames/' . $frame->image)) {
                Storage::disk('public')->delete('frames/' . $frame->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('frames', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $frame->update($data);

        return redirect()->route('admin.frames.index')->with('success', 'Frame updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Frame $frame)
    {
        if ($frame->image && Storage::disk('public')->exists('frames/' . $frame->image)) {
            Storage::disk('public')->delete('frames/' . $frame->image);
        }
        
        $frame->delete();

        return redirect()->route('admin.frames.index')->with('success', 'Frame deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Frame $frame)
    {
        $frame->status = !$frame->status;
        $frame->save();

        return redirect()->back()->with('success', 'Frame status updated successfully.');
    }
}
