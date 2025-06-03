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

           Schema::create('grades', function (Blueprint $table) {
    $table->id(); // رقم السجل (العلامة)
    $table->foreignId('student_id')->constrained('current_students')->onDelete('cascade'); // الطالب
    $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); // المادة
    //$table->foreignId('guid_id')->constrained('users')->onDelete('cascade'); // المادة
    $table->integer('exam1')->nullable(); // سبر ١
    $table->integer('exam2')->nullable(); // سبر ٢
    $table->integer('exam3')->nullable(); // سبر ٣
    $table->integer('quiz')->nullable();  // مذاكرة
    $table->integer('final_exam')->nullable(); // الامتحان النهائي
    $table->date('date')->nullable(); // تاريخ التقييم

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
