<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faq::orderBy('sorting', 'asc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        $faqs = $query->paginate(10)->appends($request->all());

        return view('admin.pages.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.faqs.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'sorting' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $data = $request->only(['question', 'answer', 'sorting', 'status']);
        $data['sorting'] = $data['sorting'] ?? 0;

        if ($request->hasFile('icon')) {
            $iconName = time() . '_' . uniqid() . '.' . $request->icon->extension();
            $request->icon->storeAs('faqs', $iconName, 'public');
            $data['icon'] = $iconName;
        }

        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return view('admin.pages.faqs.form', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'sorting' => 'nullable|integer',
            'status' => 'required|boolean',
        ]);

        $data = $request->only(['question', 'answer', 'sorting', 'status']);
        $data['sorting'] = $data['sorting'] ?? 0;

        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($faq->icon && Storage::disk('public')->exists('faqs/' . $faq->icon)) {
                Storage::disk('public')->delete('faqs/' . $faq->icon);
            }

            $iconName = time() . '_' . uniqid() . '.' . $request->icon->extension();
            $request->icon->storeAs('faqs', $iconName, 'public');
            $data['icon'] = $iconName;
        }

        $faq->update($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        if ($faq->icon && Storage::disk('public')->exists('faqs/' . $faq->icon)) {
            Storage::disk('public')->delete('faqs/' . $faq->icon);
        }

        $faq->delete();

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    /**
     * Toggle status of the specified resource.
     */
    public function toggleStatus(Faq $faq)
    {
        $faq->status = !$faq->status;
        $faq->save();

        return redirect()->back()->with('success', 'FAQ status updated successfully.');
    }
}
