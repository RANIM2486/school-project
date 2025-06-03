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
        Schema::create('current_students', function (Blueprint $table) {
    $table->id(); // رقم السجل (رقم تسلسلي)

    $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // الطالب المرتبط
    $table->foreignId('class_id')->constrained('classes')->onDelete('cascade'); // الصف المرتبط
    $table->foreignId('section_id')->constrained('sections')->onDelete('cascade'); // الشعبة المرتبطة
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_students');
    }
};
