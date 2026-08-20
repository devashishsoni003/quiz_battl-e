<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class PageApiController extends Controller
{
    /**
     * Fetch About Us CMS page.
     */
    public function aboutUs(): JsonResponse
    {
        return $this->getPageBySlug('about-us');
    }

    /**
     * Fetch Privacy Policy CMS page.
     */
    public function privacyPolicy(): JsonResponse
    {
        return $this->getPageBySlug('privacy-policy');
    }

    /**
     * Fetch Terms & Conditions CMS page.
     */
    public function termsAndConditions(): JsonResponse
    {
        return $this->getPageBySlug('terms-and-conditions');
    }

    /**
     * Fetch any active CMS page dynamically by slug.
     */
    public function getPage(string $slug): JsonResponse
    {
        return $this->getPageBySlug($slug);
    }

    /**
     * Helper to fetch active page from database and return standard JSON response.
     */
    protected function getPageBySlug(string $slug): JsonResponse
    {
        $page = Page::where('slug', $slug)
            ->where('status', 1)
            ->first();

        if (!$page) {
            return response()->json([
                'status' => false,
                'message' => 'Page not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'CMS page fetched successfully.',
            'data' => [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $page->content,
                'description' => $page->content,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
            ],
        ], 200);
    }
}
