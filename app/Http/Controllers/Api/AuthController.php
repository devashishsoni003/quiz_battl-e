<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Send OTP to the mobile number (Mocked).
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
        $otp = rand(1000, 9999);

        Cache::put('otp_' . $mobileNumber, $otp, now()->addMinutes(5));

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

            // Log the full response for debugging
            Log::info('Pearl SMS Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->failed()) {
                Log::error('Pearl SMS Error', ['response' => $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('Pearl SMS Exception', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully',
            'mobile_number' => $mobileNumber
        ]);
    }

    /**
     * Verify OTP and Login / Register user.
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

        // Retrieve the stored OTP
        $storedOtp = Cache::get('otp_' . $mobileNumber);

        if (!$storedOtp || $storedOtp != $otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired OTP.'
            ], 400);
        }

        // Clear the OTP once used successfully
        Cache::forget('otp_' . $mobileNumber);

        // Check if user already exists
        $user = User::where('mobile_number', $mobileNumber)->first();
        $isNewUser = false;

        if (!$user) {
            // Register new user
            $user = User::create([
                'mobile_number' => $mobileNumber,
                'username' => 'user_' . substr($mobileNumber, -4), // Default username
                'image' => null,
                'dob' => null,
                'gender' => null,
            ]);
            $isNewUser = true;
        }

        // Generate Bearer Token via Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => $isNewUser ? 'User registered successfully' : 'Login successful',
            'is_new_user' => $isNewUser,
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 200);
    }

    /**
     * Log out the authenticated user (revoke current token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ], 200);
    }
}
