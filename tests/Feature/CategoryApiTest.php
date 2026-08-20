<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test fetching paginated categories list.
     */
    public function test_can_fetch_paginated_categories(): void
    {
        // 1. Get initial count of active categories
        $initialActiveCount = Category::where('status', 1)->count();

        // 2. Create 15 categories (all active/status=1)
        for ($i = 1; $i <= 15; $i++) {
            Category::create([
                'title' => "Category {$i}",
                'image' => "image_{$i}.png",
                'sorting' => $i,
                'status' => 1,
            ]);
        }

        $expectedTotal = $initialActiveCount + 15;

        // 3. Fetch page 1
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Categories fetched successfully.',
            ])
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'current_page',
                    'data',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'links',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ]
            ]);

        // Page 1 should contain exactly 10 categories if there are at least 10
        $this->assertCount(10, $response->json('data.data'));
        $this->assertEquals($expectedTotal, $response->json('data.total'));
        $this->assertEquals(1, $response->json('data.current_page'));

        // 4. Fetch page 2
        $responsePage2 = $this->getJson('/api/v1/categories?page=2');

        $responsePage2->assertStatus(200);
        // Page 2 should contain exactly 10 categories if expectedTotal is at least 20, or (expectedTotal - 10)
        $expectedPage2Count = min(10, $expectedTotal - 10);
        $this->assertCount($expectedPage2Count, $responsePage2->json('data.data'));
        $this->assertEquals(2, $responsePage2->json('data.current_page'));
    }
}
