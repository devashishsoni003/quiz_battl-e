<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\SuperAdmin;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test FAQ Creation by Admin.
     */
    public function test_admin_can_create_faq(): void
    {
        Storage::fake('public');

        $admin = SuperAdmin::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_faq_test@example.com',
            'password' => 'password123',
        ]);

        $icon = UploadedFile::fake()->image('faq_icon.png');

        $response = $this->actingAs($admin, 'super_admin')
            ->post(route('admin.faqs.store'), [
                'question' => 'What is Quiz Battle?',
                'answer' => 'Quiz Battle is a fun game.',
                'icon' => $icon,
                'sorting' => 10,
                'status' => 1,
            ]);

        $response->assertRedirect(route('admin.faqs.index'));

        $faq = Faq::where('question', 'What is Quiz Battle?')->first();
        $this->assertNotNull($faq->icon);

        $this->assertDatabaseHas('faqs', [
            'question' => 'What is Quiz Battle?',
            'answer' => 'Quiz Battle is a fun game.',
            'sorting' => 10,
            'status' => true,
        ]);

        Storage::disk('public')->assertExists('faqs/' . $faq->icon);
    }

    /**
     * Test FAQ Update by Admin.
     */
    public function test_admin_can_update_faq(): void
    {
        Storage::fake('public');

        $admin = SuperAdmin::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_faq_test2@example.com',
            'password' => 'password123',
        ]);

        $faq = Faq::create([
            'question' => 'Old Question',
            'answer' => 'Old Answer',
            'sorting' => 1,
            'status' => true,
        ]);

        $icon = UploadedFile::fake()->image('new_faq_icon.png');

        $response = $this->actingAs($admin, 'super_admin')
            ->put(route('admin.faqs.update', $faq->id), [
                'question' => 'New Question',
                'answer' => 'New Answer',
                'icon' => $icon,
                'sorting' => 5,
                'status' => 0,
            ]);

        $response->assertRedirect(route('admin.faqs.index'));

        $faq->refresh();
        $this->assertNotNull($faq->icon);

        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'New Question',
            'answer' => 'New Answer',
            'sorting' => 5,
            'status' => false,
        ]);

        Storage::disk('public')->assertExists('faqs/' . $faq->icon);
    }

    /**
     * Test FAQ Status Toggle by Admin.
     */
    public function test_admin_can_toggle_faq_status(): void
    {
        $admin = SuperAdmin::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_faq_test3@example.com',
            'password' => 'password123',
        ]);

        $faq = Faq::create([
            'question' => 'Toggle Status Question',
            'answer' => 'Toggle Status Answer',
            'sorting' => 1,
            'status' => true,
        ]);

        $response = $this->actingAs($admin, 'super_admin')
            ->post(route('admin.faqs.toggle-status', $faq->id));

        $response->assertRedirect();
        
        $faq->refresh();
        $this->assertFalse($faq->status);
    }

    /**
     * Test FAQ Delete by Admin.
     */
    public function test_admin_can_delete_faq(): void
    {
        $admin = SuperAdmin::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin_faq_test4@example.com',
            'password' => 'password123',
        ]);

        $faq = Faq::create([
            'question' => 'Delete Question',
            'answer' => 'Delete Answer',
            'sorting' => 1,
            'status' => true,
        ]);

        $response = $this->actingAs($admin, 'super_admin')
            ->delete(route('admin.faqs.destroy', $faq->id));

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    /**
     * Test Help & Support API returns only active FAQs sorted by sorting field.
     */
    public function test_api_returns_active_faqs_sorted(): void
    {
        // Clear existing FAQs
        Faq::query()->delete();

        // Create sorted FAQs
        Faq::create(['question' => 'Q3', 'answer' => 'A3', 'sorting' => 3, 'status' => true]);
        Faq::create(['question' => 'Q1', 'answer' => 'A1', 'sorting' => 1, 'status' => true]);
        Faq::create(['question' => 'Q2', 'answer' => 'A2', 'sorting' => 2, 'status' => true]);
        Faq::create(['question' => 'Q4-Inactive', 'answer' => 'A4', 'sorting' => 4, 'status' => false]);

        $response = $this->getJson('/api/v1/help-support');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Help & Support fetched successfully.',
            ]);

        $faqs = $response->json('data.faqs');
        $whatsappNumber = $response->json('data.whatsapp_number');
        
        $this->assertNotNull($whatsappNumber);
        $this->assertCount(3, $faqs);

        // Verify sorting order and presence of icon
        $this->assertEquals('Q1', $faqs[0]['question']);
        $this->assertArrayHasKey('icon', $faqs[0]);
        $this->assertEquals('Q2', $faqs[1]['question']);
        $this->assertEquals('Q3', $faqs[2]['question']);
    }

    /**
     * Test Help & Support API returns empty standard response when no active FAQs exist.
     */
    public function test_api_returns_empty_when_no_active_faqs(): void
    {
        Faq::query()->delete();

        $response = $this->getJson('/api/v1/help-support');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'No FAQs available.',
                'data' => [
                    'faqs' => []
                ]
            ]);
    }
}
