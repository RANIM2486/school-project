<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
      subject::factory(10)->create();
    }
}
