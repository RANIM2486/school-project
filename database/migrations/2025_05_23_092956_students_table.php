<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
       Schema::create('students', function (Blueprint $table) {
    $table->id(); // رقم الطالبs
    $table->string('first_name');      // الاسم الأول
    $table->string('father_name');     // اسم الأب
    $table->string('mother_name');     // اسم الأم
    $table->string('last_name');       // الكنية
    $table->enum('gender', ['ذكر', 'أنثى']); // الجنس
    $table->date('birth_date');        // تاريخ الميلاد
    $table->string('address')->nullable(); // العنوان
    $table->date('entry_date');        // تاريخ الدخول للمدرسة
    //$table->unsignedBigInteger('class_id');
    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');   // حساب الطالب نفسه
    $table->foreignId('parent_id')->constrained('users')->onDelete('cascade'); // حساب ولي الأمر
  $table->foreignId('class_id')->constrained('classes')->onDelete('cascade'); //   // الصف
    $table->foreignId('section_id')->constrained('sections')->onDelete('cascade'); // الشعبة

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
