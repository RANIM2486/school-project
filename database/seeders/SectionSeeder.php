<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\section;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        section::factory()->count(10)->create();
    }
}
