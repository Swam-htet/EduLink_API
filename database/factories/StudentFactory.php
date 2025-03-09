<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Auth & Basic Info
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_active' => true,
            'student_id' => fake()->unique()->numerify('STU####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->phoneNumber(),
            'date_of_birth' => fake()->dateTimeBetween('-18 years', '-6 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'address' => fake()->address(),
            // Parent Information
            'parent_name' => fake()->name(),
            'parent_phone' => fake()->phoneNumber(),
            'parent_email' => fake()->optional()->safeEmail(),
            'parent_occupation' => fake()->jobTitle(),
            'parent_address' => fake()->optional()->address(),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
            // Academic Information
            'current_grade' => fake()->randomElement(['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6']),
            'previous_school' => fake()->optional()->company(),
            'previous_gpa' => fake()->optional()->randomFloat(2, 2, 4),
            'enrollment_date' => fake()->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'blood_group' => fake()->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'medical_conditions' => fake()->optional()->sentence(),
            'allergies' => fake()->optional()->words(3, true),
            'extra_curricular_activities' => fake()->randomElements(['Sports', 'Music', 'Dance', 'Art', 'Chess', 'Debate'], rand(0, 3)),
            'achievements' => fake()->randomElements(['Academic Excellence', 'Sports Champion', 'Art Competition Winner', 'Science Fair Winner'], rand(0, 2)),
            // Documents
            'profile_photo' => null,
            'birth_certificate' => null,
            'previous_school_records' => null,
            'medical_records' => null,
            // Additional Information
            'bio' => fake()->optional()->paragraph(),
            'nationality' => fake()->country(),
            'religion' => fake()->optional()->randomElement(['Christianity', 'Islam', 'Buddhism', 'Hinduism', 'Other']),
            'language_spoken' => fake()->languageCode(),
            'is_scholarship_recipient' => fake()->boolean(20),
            'scholarship_details' => function (array $attributes) {
                return $attributes['is_scholarship_recipient'] ? fake()->sentence() : null;
            },
            'requires_bus_service' => fake()->boolean(40),
            'bus_route_number' => function (array $attributes) {
                return $attributes['requires_bus_service'] ? 'Route-' . fake()->numberBetween(1, 10) : null;
            },
        ];
    }
}
