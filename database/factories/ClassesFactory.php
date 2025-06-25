<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'الصف الأول', 'الصف الثاني', 'الصف الثالث', 'الصف الرابع', 'الصف الخامس', 'الصف السادس'
            ]),
            'level' => $this->faker->randomElement([
                'ابتدائي', 'إعدادي', 'ثانوي'
            ]),
            'students_count' => $this->faker->numberBetween(10, 50),
            'fees' => $this->faker->randomFloat(2, 100000, 500000), // من 100,000 إلى 500,000
        ];
    }
}
