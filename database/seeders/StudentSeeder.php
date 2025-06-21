<?php
namespace Database\Seeders;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {

           Student::create([
    'first_name' => 'John',
    'father_name' => 'Doe',
    'mother_name' => 'Jane',
    'last_name' => 'Smith',
    'gender' => 'أنثى',
    'birth_date' => '2000-01-01',
    //'national_id' => '1234567890',
    'address' => '123 Main St',
    'entry_date' => now(),
    'student_id' => 1, // تأكد من تضمين user_id
    'parent_id' => 1,
    'class_id' => 1,
    'section_id' => 1,
]);
   Student::create([
    'first_name' => 'John',
    'father_name' => 'Doe',
    'mother_name' => 'Jane',
    'last_name' => 'Smith',
    'gender' => 'أنثى',
    'birth_date' => '2000-01-01',
    //'national_id' => '1234567890',
    'address' => '123 Main St',
    'entry_date' => now(),
    'student_id' => 2, // تأكد من تضمين user_id
    'parent_id' => 1,
    'class_id' => 1,
    'section_id' => 1,

]);
    }
}
