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
       Schema::create('classes', function (Blueprint $table) {
  $table->id(); // رقم الصف
    $table->string('name'); // اسم الصف (مثلاً: الصف الرابع)
    $table->string('level'); // المرحلة الدراسية (ابتدائي، ثانوي...)
    $table->integer('students_count')->default(0); // عدد الطلاب في الصف
    $table->decimal('fees', 10, 2); // قيمة القسط (مثلاً: 250000.00)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
