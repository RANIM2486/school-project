<?php

namespace Database\Factories;

use App\Models\student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\student>
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
             'first_name' => $this->faker->firstName,
            'father_name' => $this->faker->firstName,
            'mother_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'gender' => $this->faker->randomElement(['ذكر', 'أنثى']),
            'birth_date' => $this->faker->date,
            'address' => $this->faker->address,
            'entry_date' => $this->faker->date,
            //'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'parent_id' => \App\Models\User::inRandomOrder()->first()->id,
            'class_id' => \App\Models\classes::inRandomOrder()->first()->id,
            'section_id' => \App\Models\section::inRandomOrder()->first()->id,
        ];
    }
}
