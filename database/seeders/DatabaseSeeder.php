<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. إنشاء أو تحديث المستخدمين الافتراضيين (يمنع خطأ Duplicate entry)
        $user1 = User::updateOrCreate(
            ['email' => 'ahmed@example.com'],
            ['name' => 'أحمد العلي', 'password' => Hash::make('password123')]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'sarah@example.com'],
            ['name' => 'سارة حسن', 'password' => Hash::make('password123')]
        );

        $user3 = User::updateOrCreate(
            ['email' => 'mohamed@example.com'],
            ['name' => 'محمد محمود', 'password' => Hash::make('password123')]
        );

        // 2. إنشاء الفئات (إذا كانت موجودة سيتخطاها)
        $work = Category::firstOrCreate(['name' => 'العمل'], ['color' => '#ff0000']);
        $study = Category::firstOrCreate(['name' => 'الدراسة'], ['color' => '#0000ff']);
        $personal = Category::firstOrCreate(['name' => 'شخصي'], ['color' => '#00ff00']);
        $shopping = Category::firstOrCreate(['name' => 'التسوق'], ['color' => '#ffa500']);
        $health = Category::firstOrCreate(['name' => 'الصحة'], ['color' => '#800080']);

        // 3. تعطيل قيود المفاتيح الأجنبية لتفريغ جدول المهام بأمان دون أخطاء
        Schema::disableForeignKeyConstraints();
        DB::table('tasks')->truncate();
        Schema::enableForeignKeyConstraints(); // إعادة تفعيل القيود مباشرة بعد التفريغ

        // 4. إنشاء المهام الافتراضية
        Task::create([
            'user_id' => $user1->id,
            'category_id' => $work->id,
            'task_title' => 'تسليم مشروع لارافيل النهائي للمركز',
            'status' => 'pending',
        ]);

        Task::create([
            'user_id' => $user2->id,
            'category_id' => $study->id,
            'task_title' => 'مذاكرة كود الـ Controller والـ Views جيداً',
            'status' => 'completed',
        ]);

        Task::create([
            'user_id' => $user3->id,
            'category_id' => $health->id,
            'task_title' => 'الذهاب إلى النادي الرياضي والمحافظة على الصحة',
            'status' => 'pending',
        ]);

        $archivedTask = Task::create([
            'user_id' => $user1->id,
            'category_id' => $personal->id,
            'task_title' => 'مهمة قديمة جداً تم إنجازها وحذفها للأرشيف الموقت',
            'status' => 'completed',
        ]);

        $archivedTask->delete();
    }
}
