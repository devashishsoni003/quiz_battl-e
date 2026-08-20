<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;

class HelpSupportApiController extends Controller
{
    /**
     * Fetch active FAQs and Admin WhatsApp Support.
     */
    public function index()
    {
        $faqs = Faq::where('status', 1)
            ->orderBy('sorting', 'asc')
            ->get(['id', 'question', 'answer', 'icon'])
            ->map(function ($faq) {
                return [
                    'id' => $faq->id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                    'icon' => $faq->icon_url,
                ];
            });

        // Fetch WhatsApp number from Super Admin profile
        $admin = SuperAdmin::orderBy('id', 'asc')->first();
        $whatsappNumber = $admin ? ($admin->whatsapp_number ?? '') : '';

        if ($faqs->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'No FAQs available.',
                'data' => [
                    'whatsapp_number' => $whatsappNumber,
                    'faqs' => []
                ]
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Help & Support fetched successfully.',
            'data' => [
                'whatsapp_number' => $whatsappNumber,
                'faqs' => $faqs
            ]
        ], 200);
    }
}
