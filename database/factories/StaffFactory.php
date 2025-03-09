<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
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
            'staff_id' => fake()->unique()->numerify('STF####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone_number' => fake()->phoneNumber(),
            'department' => fake()->randomElement(['Mathematics', 'Science', 'English', 'History', 'Computer Science']),
            'designation' => fake()->randomElement(['Teacher', 'Senior Teacher', 'Head of Department', 'Coordinator']),
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-25 years')->format('Y-m-d'),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'address' => fake()->address(),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
            // Professional Info
            'qualification' => fake()->randomElement(['B.Ed', 'M.Ed', 'PhD', 'MA', 'MSc']),
            'specialization' => fake()->sentence(),
            'joining_date' => fake()->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'salary' => fake()->numberBetween(30000, 100000),
            'bank_account_number' => fake()->bankAccountNumber(),
            'bank_name' => fake()->company(),
            'profile_photo' => null,
            'bio' => fake()->paragraph(),
            'certifications' => fake()->randomElements(['Teaching License', 'First Aid', 'Special Education', 'Digital Learning'], rand(1, 3)),
            'teaching_subjects' => fake()->randomElements(['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'History'], rand(1, 3)),
            'is_department_head' => fake()->boolean(20),
        ];
    }
}
