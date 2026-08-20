<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pages.sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.sellers.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|numeric|digits:10|unique:sellers,mobile_number',
            'email' => 'required|email|unique:sellers,email',
            'whatsapp_number' => 'nullable|numeric|digits_between:10,15',
            'coins' => 'required|integer|min:0',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->except(['image', 'password', 'password_confirmation']);
        $data['password'] = bcrypt($request->input('password'));

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->storeAs('sellers', $imageName, 'public');
            $data['image'] = $imageName;
        }

        Seller::create($data);

        return redirect()->route('admin.sellers.index')->with('success', 'Seller created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seller $seller)
    {
        return view('admin.pages.sellers.form', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seller $seller)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|numeric|digits:10|unique:sellers,mobile_number,' . $seller->id,
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'whatsapp_number' => 'nullable|numeric|digits_between:10,15',
            'coins' => 'required|integer|min:0',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = $request->except(['image', 'password', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($seller->image && Storage::disk('public')->exists('sellers/' . $seller->image)) {
                Storage::disk('public')->delete('sellers/' . $seller->image);
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->storeAs('sellers', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $seller->update($data);

        return redirect()->route('admin.sellers.index')->with('success', 'Seller updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        if ($seller->image && Storage::disk('public')->exists('sellers/' . $seller->image)) {
            Storage::disk('public')->delete('sellers/' . $seller->image);
        }

        $seller->delete();

        return redirect()->route('admin.sellers.index')->with('success', 'Seller deleted successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(Seller $seller)
    {
        $seller->status = !$seller->status;
        $seller->save();

        return redirect()->back()->with('success', 'Seller status updated successfully.');
    }
}
