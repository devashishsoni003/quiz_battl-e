<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['title' => 'About Us', 'slug' => 'about-us'],
            ['title' => 'Privacy Policy', 'slug' => 'privacy-policy'],
            ['title' => 'Terms & Conditions', 'slug' => 'terms-and-conditions'],
            ['title' => 'Contact Us', 'slug' => 'contact-us'],
            ['title' => 'FAQ', 'slug' => 'faq'],
        ];

        foreach ($pages as $page) {
            \App\Models\Page::firstOrCreate(
                ['slug' => $page['slug']],
                [
                    'title' => $page['title'],
                    'content' => '<p>Default content for ' . $page['title'] . '.</p>',
                    'status' => 1,
                ]
            );
        }
    }
}
