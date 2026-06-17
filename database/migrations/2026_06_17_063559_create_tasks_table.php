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
        // نحذف الجدول القديم المشوه أولاً لضمان إعادة بنائه بالأعمدة الجديدة
        Schema::dropIfExists('tasks');

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // إضافة العلاقات والأعمدة المطلوبة كاملة للـ Seeder
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('task_title');
            $table->string('status')->default('pending');

            $table->softDeletes(); // مهم جداً للأرشفة والـ delete في الـ Seeder
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
