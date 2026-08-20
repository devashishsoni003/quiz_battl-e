<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form for Sellers.
     */
    public function showLoginForm()
    {
        return view('seller.pages.login');
    }

    /**
     * Send OTP to Seller's mobile number.
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $mobileNumber = $request->input('mobile_number');

        // Verify that the seller exists and is active
        $seller = Seller::where('mobile_number', $mobileNumber)->where('status', 1)->first();
        if (!$seller) {
            return response()->json([
                'status' => 'error',
                'message' => 'This mobile number is not registered as an active seller.'
            ], 404);
        }

        // Generate OTP
        if ($mobileNumber === '1234567890') {
            $otp = '1234';
        } else {
            $otp = rand(1000, 9999);
        }

        // Cache the OTP for 5 minutes
        Cache::put('otp_' . $mobileNumber, $otp, now()->addMinutes(5));

        // Send OTP using the Pearl SMS gateway (skip for demo account)
        if ($mobileNumber !== '1234567890') {
            $apiUrl = env('PEARL_SMS_API_URL');
            $apiKey = env('PEARL_SMS_API_KEY');
            $senderId = env('PEARL_SMS_SENDER_ID');
            $templateId = env('PEARL_SMS_TEMPLATE_ID');
            $peId = env('PEARL_SMS_PE_ID');

            $payload = [
                'apikey' => $apiKey,
                'numbers' => $mobileNumber,
                'message' => "Your OTP is {$otp}. Use this to verify your mobile number on SPPLFW. Valid for 5 minutes.",
                'sender' => $senderId,
                'route' => '4',
                'country' => '91',
                'smstype' => 'TRANS'
            ];

            if (!empty($templateId)) {
                $payload['templateid'] = $templateId;
            }

            if (!empty($peId)) {
                $payload['peid'] = $peId;
            }

            try {
                $response = Http::get($apiUrl, $payload);

                Log::info('Pearl SMS Response for Seller', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                if ($response->failed()) {
                    Log::error('Pearl SMS Error for Seller', ['response' => $response->body()]);
                }
            } catch (\Exception $e) {
                Log::error('Pearl SMS Exception for Seller', ['error' => $e->getMessage()]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully.'
        ]);
    }

    /**
     * Verify OTP and log in Seller.
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric|digits:10',
            'otp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $mobileNumber = $request->input('mobile_number');
        $otp = $request->input('otp');

        // Retrieve cached OTP
        $storedOtp = Cache::get('otp_' . $mobileNumber);

        // Support demo login bypass
        if ($mobileNumber === '1234567890' && $otp === '1234') {
            $storedOtp = '1234';
        }

        if (!$storedOtp || $storedOtp != $otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired OTP.'
            ], 400);
        }

        // Clear the OTP from cache
        Cache::forget('otp_' . $mobileNumber);

        // Authenticate the seller
        $seller = Seller::where('mobile_number', $mobileNumber)->where('status', 1)->first();
        if (!$seller) {
            return response()->json([
                'status' => 'error',
                'message' => 'Seller not found.'
            ], 404);
        }

        Auth::guard('seller')->login($seller);

        $request->session()->flash('toast_success', 'Welcome back, ' . $seller->name);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful.',
            'redirect' => route('seller.dashboard')
        ]);
    }

    /**
     * Log out the Seller.
     */
    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('toast_success', 'Logged out successfully.');

        return redirect()->route('seller.login');
    }
}
