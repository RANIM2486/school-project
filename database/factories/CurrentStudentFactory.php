<?php

namespace Database\Factories;

use App\Models\Current_Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Current_Student>
 */
class CurrentStudentFactory extends Factory
{
    protected $model = Current_Student::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(['مستمر', 'مغادر', 'مؤجل']),
            'student_id' => \App\Models\student::inRandomOrder()->first()->id,
            'class_id' => \App\Models\classes::inRandomOrder()->first()->id,
            'section_id' => \App\Models\section::inRandomOrder()->first()->id,
        ];
    }
}
