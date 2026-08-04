<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.pages.dashboard');
    }

    /**
     * Show Super Admin Profile.
     */
    public function profile()
    {
        $user = Auth::guard('super_admin')->user();
        return view('admin.pages.profile', compact('user'));
    }

    /**
     * Update Super Admin Personal Info.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('super_admin')->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:super_admins,email,' . $user->id,
            'contact_number' => 'required|string|max:20',
            'gender' => 'required|string|in:male,female,other',
            'image' => 'nullable|image|max:2048', // max 2MB
        ]);

        $data = $request->only(['first_name', 'last_name', 'email', 'contact_number', 'gender']);

        if ($request->hasFile('image')) {
            // Ensure destination directory exists
            $destPath = public_path('uploads/admins');
            if (!file_exists($destPath)) {
                mkdir($destPath, 0755, true);
            }

            // Delete old image if exists
            if ($user->image && file_exists($destPath . '/' . $user->image)) {
                @unlink($destPath . '/' . $user->image);
            }

            // Store new image
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move($destPath, $imageName);
            $data['image'] = $imageName;
        }

        $user->update($data);

        $request->session()->flash('toast_success', 'Profile updated successfully');
        return redirect()->back()->with('active_tab', 'personal');
    }

    /**
     * Change Super Admin Password.
     */
    public function changePassword(Request $request)
    {
        $user = Auth::guard('super_admin')->user();

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8|different:old_password',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'confirm_password.same' => 'New password confirmation does not match.',
            'new_password.different' => 'New password must be different from old password.',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['old_password' => 'Old password does not match.'])
                ->with('active_tab', 'password');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        $request->session()->flash('toast_success', 'Password changed successfully');
        return redirect()->back()->with('active_tab', 'password');
    }
}
