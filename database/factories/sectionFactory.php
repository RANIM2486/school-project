<?php

namespace Database\Factories;

use App\Models\section;
use App\Models\User;
use App\Models\classes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\section>
 */
class sectionFactory extends Factory
{
    protected $model = section::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'شعبة A', 'شعبة B', 'شعبة C', 'شعبة D'
            ]),
            'class_id' => Classes::factory(), // ينشئ صف جديد مرتبط بالشعبة
            'guide_id' => User::factory(),    // ينشئ مستخدم جديد كمرشد
            'teacher_id' => User::factory()
        ];
    }
}
