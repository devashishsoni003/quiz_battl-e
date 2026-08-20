<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed default pages
        Page::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => '<p>About Us content.</p>',
            'meta_title' => 'About Us SEO',
            'meta_description' => 'About Us meta description',
            'status' => 1,
        ]);

        Page::create([
            'title' => 'Privacy Policy',
            'slug' => 'privacy-policy',
            'content' => '<p>Privacy Policy content.</p>',
            'meta_title' => 'Privacy Policy SEO',
            'meta_description' => 'Privacy Policy meta description',
            'status' => 1,
        ]);

        Page::create([
            'title' => 'Terms & Conditions',
            'slug' => 'terms-and-conditions',
            'content' => '<p>Terms & Conditions content.</p>',
            'meta_title' => 'Terms & Conditions SEO',
            'meta_description' => 'Terms & Conditions meta description',
            'status' => 1,
        ]);
    }

    public function test_can_fetch_about_us_page(): void
    {
        $response = $this->getJson('/api/about-us');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'CMS page fetched successfully.',
                'data' => [
                    'title' => 'About Us',
                    'slug' => 'about-us',
                    'content' => '<p>About Us content.</p>',
                    'description' => '<p>About Us content.</p>',
                    'meta_title' => 'About Us SEO',
                    'meta_description' => 'About Us meta description',
                ]
            ]);
    }

    public function test_can_fetch_privacy_policy_page(): void
    {
        $response = $this->getJson('/api/privacy-policy');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'CMS page fetched successfully.',
                'data' => [
                    'title' => 'Privacy Policy',
                    'slug' => 'privacy-policy',
                    'content' => '<p>Privacy Policy content.</p>',
                ]
            ]);
    }

    public function test_can_fetch_terms_and_conditions_page(): void
    {
        $response = $this->getJson('/api/terms-and-conditions');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'CMS page fetched successfully.',
                'data' => [
                    'title' => 'Terms & Conditions',
                    'slug' => 'terms-and-conditions',
                    'content' => '<p>Terms & Conditions content.</p>',
                ]
            ]);
    }

    public function test_can_fetch_pages_via_v1_prefix(): void
    {
        $response = $this->getJson('/api/v1/about-us');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'data' => [
                    'slug' => 'about-us',
                ]
            ]);
    }

    public function test_can_fetch_page_via_dynamic_slug(): void
    {
        $response = $this->getJson('/api/v1/pages/about-us');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'data' => [
                    'slug' => 'about-us',
                ]
            ]);
    }

    public function test_returns_404_when_page_not_found(): void
    {
        $response = $this->getJson('/api/pages/non-existing-page');

        $response->assertStatus(404)
            ->assertJson([
                'status' => false,
                'message' => 'Page not found.',
            ]);
    }

    public function test_returns_404_when_page_is_inactive(): void
    {
        Page::where('slug', 'about-us')->update(['status' => 0]);

        $response = $this->getJson('/api/about-us');

        $response->assertStatus(404)
            ->assertJson([
                'status' => false,
                'message' => 'Page not found.',
            ]);
    }

    public function test_returns_404_when_page_is_soft_deleted(): void
    {
        Page::where('slug', 'about-us')->delete();

        $response = $this->getJson('/api/about-us');

        $response->assertStatus(404)
            ->assertJson([
                'status' => false,
                'message' => 'Page not found.',
            ]);
    }
}
