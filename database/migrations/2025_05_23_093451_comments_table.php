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
        Schema::create('comments', function (Blueprint $table) {
    $table->id(); // رقم الملاحظة
    $table->string('name'); // اسم الملاحظة
    $table->date('date'); // تاريخ الملاحظة
    $table->enum('type', ['إيجابية', 'سلبية', 'تحذير']); // نوع الملاحظة
    $table->foreignId('student_id')->constrained('current_students')->onDelete('cascade'); // الطالب المرتبط
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

