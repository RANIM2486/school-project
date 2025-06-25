<?php

namespace Database\Factories;

use App\Models\subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\subject>
 */
class SubjectFactory extends Factory
{
     protected $model = subject::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'min_grade' => $this->faker->numberBetween(0, 50),
            'max_grade' => $this->faker->numberBetween(51, 100),
            'exam1' => $this->faker->numberBetween(0, 100),
            'exam2' => $this->faker->numberBetween(0, 100),
            'exam3' => $this->faker->numberBetween(0, 100),
            'final_exam' => $this->faker->numberBetween(0, 100),
            'teacher_id' => \App\Models\User::inRandomOrder()->first()->id,
        ];
    }
}
