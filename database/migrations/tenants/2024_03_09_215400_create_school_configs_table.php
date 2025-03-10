<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tenants\TenantConfig;

return new class extends Migration
{
    public function up(): void
    {
        // Insert default school configuration
        $defaultConfig = [
            // Basic Information
            'school.basic' => [
                'name' => 'Demo School',
                'logo' => '/images/default/logo.png',
                'favicon' => '/images/default/favicon.ico',
                'slogan' => 'Empowering Minds, Shaping Futures',
                'established' => '2024',
                'accreditation' => ['General Accreditation Board'],
            ],

            // Contact Information
            'school.contact' => [
                'phone' => '+1234567890',
                'email' => 'info@school.edu',
                'address' => '123 Education Street, Learning City, 12345',
                'mapUrl' => 'https://maps.google.com',
                'operatingHours' => [
                    [
                        'days' => 'Monday - Friday',
                        'hours' => '8:00 AM - 5:00 PM'
                    ],
                    [
                        'days' => 'Saturday',
                        'hours' => '9:00 AM - 1:00 PM'
                    ]
                ]
            ],

            // Hero Section
            'school.hero' => [
                'title' => 'Welcome to Our School',
                'subtitle' => 'Where Excellence Meets Education',
                'backgroundImage' => '/images/default/hero-bg.jpg',
                'stats' => [
                    [
                        'label' => 'Students',
                        'value' => '1000+'
                    ],
                    [
                        'label' => 'Courses',
                        'value' => '50+'
                    ],
                    [
                        'label' => 'Graduates',
                        'value' => '5000+'
                    ]
                ]
            ],

            // About Section
            'school.about' => [
                'title' => 'About Our Institution',
                'description' => 'We are committed to providing quality education and shaping future leaders.',
                'image' => '/images/default/about.jpg',
                'features' => [
                    [
                        'icon' => 'graduation-cap',
                        'title' => 'Quality Education',
                        'description' => 'World-class curriculum and teaching methods'
                    ],
                    [
                        'icon' => 'users',
                        'title' => 'Expert Faculty',
                        'description' => 'Experienced and dedicated teaching staff'
                    ],
                    [
                        'icon' => 'building',
                        'title' => 'Modern Facilities',
                        'description' => 'State-of-the-art infrastructure and resources'
                    ]
                ]
            ],

            // Programs Section
            'school.programs' => [
                'title' => 'Our Programs',
                'description' => 'Discover our wide range of academic programs',
                'categories' => [
                    [
                        'name' => 'Undergraduate',
                        'courses' => [
                            [
                                'title' => 'Computer Science',
                                'duration' => '4 years',
                                'level' => 'Bachelor',
                                'description' => 'Comprehensive computer science program',
                                'image' => '/images/default/cs.jpg'
                            ]
                        ]
                    ]
                ]
            ],

            // News Section
            'school.news' => [
                'title' => 'Latest News & Events',
                'description' => 'Stay updated with our latest happenings',
                'items' => [
                    [
                        'title' => 'New Semester Begins',
                        'date' => '2024-03-01',
                        'image' => '/images/default/news1.jpg',
                        'excerpt' => 'Welcome to the new academic semester',
                        'category' => 'Academic'
                    ]
                ]
            ],

            // Testimonials
            'school.testimonials' => [
                'title' => 'What Our Students Say',
                'description' => 'Hear from our students and alumni',
                'items' => [
                    [
                        'name' => 'John Doe',
                        'role' => 'Graduate 2023',
                        'image' => '/images/default/testimonial1.jpg',
                        'quote' => 'An amazing learning experience',
                        'rating' => 5
                    ]
                ]
            ],

            // FAQs
            'school.faqs' => [
                'title' => 'Frequently Asked Questions',
                'description' => 'Find answers to common questions',
                'categories' => [
                    [
                        'name' => 'Admissions',
                        'items' => [
                            [
                                'question' => 'How do I apply?',
                                'answer' => 'You can apply through our online portal'
                            ]
                        ]
                    ]
                ]
            ],

            // Social Links
            'school.social' => [
                'facebook' => 'https://facebook.com/school',
                'instagram' => 'https://instagram.com/school',
                'twitter' => 'https://twitter.com/school',
                'youtube' => 'https://youtube.com/school',
                'linkedin' => 'https://linkedin.com/school'
            ],

            // Theme
            'school.theme' => [
                'primaryColor' => '#2563eb',
                'secondaryColor' => '#1e40af',
                'fontFamily' => 'Inter, sans-serif'
            ]
        ];

        // Insert each config with proper type and group
        foreach ($defaultConfig as $key => $value) {
            TenantConfig::create([
                'key' => $key,
                'value' => json_encode($value),
                'type' => 'json',
                'group' => explode('.', $key)[0],
                'description' => 'School configuration for ' . explode('.', $key)[1],
                'is_system' => true
            ]);
        }
    }

    public function down(): void
    {
        // Remove all school-related configs
        TenantConfig::where('key', 'like', 'school.%')->delete();
    }
};
