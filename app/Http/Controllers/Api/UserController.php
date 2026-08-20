<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get list of all users.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    /**
     * Update the authenticated user's profile details.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->has('username')) {
            $user->username = $request->input('username');
        }

        if ($request->has('dob')) {
            $user->dob = $request->input('dob');
        }

        if ($request->has('gender')) {
            $user->gender = $request->input('gender');
        }

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');

            $uploadPath = public_path('uploads/profiles');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($user->image) {
                $oldImagePath = public_path($user->image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            $filename = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            
            $imageFile->move($uploadPath, $filename);
            
            $user->image = 'uploads/profiles/' . $filename;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }

 
    public function getProfile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => $request->user()
        ], 200);
    }


    public function changePassword(Request $request)
    {
        $user = $request->user();

        // Support parameter aliases (old_password / current_password, confirm_password / new_password_confirmation)
        if ($request->has('old_password') && !$request->has('current_password')) {
            $request->merge(['current_password' => $request->input('old_password')]);
        }
        if ($request->has('confirm_password') && !$request->has('new_password_confirmation')) {
            $request->merge(['new_password_confirmation' => $request->input('confirm_password')]);
        }
        if ($request->has('new_password_confirmation') && !$request->has('confirm_password')) {
            $request->merge(['confirm_password' => $request->input('new_password_confirmation')]);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|different:current_password',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'new_password.different' => 'New password must be different from current password.',
            'confirm_password.same' => 'Confirm password must match the new password.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify current password if user already has a password set
        if (!empty($user->password)) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password does not match.',
                    'errors' => [
                        'current_password' => ['Current password does not match.']
                    ]
                ], 422);
            }
        }

        // Update password with hashed value
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully'
        ], 200);
    }
}
