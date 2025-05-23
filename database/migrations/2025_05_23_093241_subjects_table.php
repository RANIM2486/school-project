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
       Schema::create('subjects', function (Blueprint $table) {
    $table->id(); // رقم المقرر
    $table->string('name'); // اسم المقرر
    $table->integer('min_grade'); // الحد الأدنى للنجاح
    $table->integer('max_grade'); // الحد الأعلى (عادة 100)
    $table->integer('exam1')->nullable(); // سبر 1
    $table->integer('exam2')->nullable(); // سبر 2
    $table->integer('exam3')->nullable(); // سبر 3
    $table->integer('final_exam')->nullable(); // الامتحان النهائي
    $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null'); // المعلم
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
