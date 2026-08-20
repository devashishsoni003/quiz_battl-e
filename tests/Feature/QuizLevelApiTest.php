<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\QuizLevel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class QuizLevelApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test fetching quiz levels successfully.
     */
    public function test_can_fetch_quiz_levels_by_category(): void
    {
        // 1. Create Categories
        $category1 = Category::create([
            'title' => 'Science',
            'image' => 'science.png',
            'sorting' => 1,
            'status' => 1,
        ]);

        $category2 = Category::create([
            'title' => 'History',
            'image' => 'history.png',
            'sorting' => 2,
            'status' => 1,
        ]);

        // 2. Create Quiz Levels for Category 1
        $level1 = QuizLevel::create([
            'category_id' => $category1->id,
            'title' => 'Science Level 1',
            'icon' => 'icon1.png',
            'entry_coins' => 10,
            'color' => '#ffffff',
            'sorting' => 1,
            'status' => 1,
        ]);

        $level2 = QuizLevel::create([
            'category_id' => $category1->id,
            'title' => 'Science Level 2',
            'icon' => 'icon2.png',
            'entry_coins' => 20,
            'color' => '#000000',
            'sorting' => 2,
            'status' => 1,
        ]);

        // Create Quiz Level for Category 2
        $level3 = QuizLevel::create([
            'category_id' => $category2->id,
            'title' => 'History Level 1',
            'icon' => 'icon3.png',
            'entry_coins' => 15,
            'color' => '#cccccc',
            'sorting' => 1,
            'status' => 1,
        ]);

        // 3. Request for Category 1
        $response = $this->postJson('/api/v1/quiz-levels', [
            'category_id' => $category1->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Quiz levels fetched successfully.',
            ])
            ->assertJsonCount(2, 'data');

        // Check structure of returned data
        $response->assertJsonPath('data.0.id', $level1->id);
        $response->assertJsonPath('data.0.category_id', $category1->id);
        $response->assertJsonPath('data.1.id', $level2->id);

        // Verify that Category 2's level is not in the response
        $this->assertNotEquals($level3->id, $response->json('data.0.id'));
        $this->assertNotEquals($level3->id, $response->json('data.1.id'));
    }

    /**
     * Test validation fail when category_id is missing.
     */
    public function test_validation_fails_when_category_id_is_missing(): void
    {
        $response = $this->postJson('/api/v1/quiz-levels', []);

        $response->assertStatus(422)
            ->assertJson([
                'status' => false,
                'message' => 'Validation error',
            ])
            ->assertJsonStructure(['errors' => ['category_id']]);
    }

    /**
     * Test validation fail when category_id is invalid.
     */
    public function test_validation_fails_when_category_id_does_not_exist(): void
    {
        $response = $this->postJson('/api/v1/quiz-levels', [
            'category_id' => 999999,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => false,
                'message' => 'Validation error',
            ])
            ->assertJsonStructure(['errors' => ['category_id']]);
    }

    /**
     * Test fetching when category has no quiz levels.
     */
    public function test_returns_empty_data_when_category_has_no_quiz_levels(): void
    {
        $category = Category::create([
            'title' => 'Empty Category',
            'image' => 'empty.png',
            'sorting' => 5,
            'status' => 1,
        ]);

        $response = $this->postJson('/api/v1/quiz-levels', [
            'category_id' => $category->id,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Quiz levels fetched successfully.',
                'data' => [],
            ]);
    }
}
