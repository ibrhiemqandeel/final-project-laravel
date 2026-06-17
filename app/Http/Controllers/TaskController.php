<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * 1. صفحة الفهرس: عرض المهام النشطة فقط
     */
    public function index()
    {
        $tasks = Task::with(['user', 'category'])->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * 2. الحذف المؤقت: نقل المهمة للأرشيف
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'تم نقل المهمة إلى الأرشيف بنجاح.');
    }

    /**
     * 3. صفحة الأرشيف: عرض المهام المحذوفة مؤقتاً فقط
     */
    public function trashed()
    {
        $tasks = Task::onlyTrashed()->with(['user', 'category'])->get();
        return view('tasks.trashed', compact('tasks'));
    }

    /**
     * 4. الاستعادة: إرجاع المهمة للقائمة النشطة
     */
    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->route('tasks.trashed')->with('success', 'تم استعادة المهمة بنجاح.');
    }

    /**
     * 5. الحذف القسري: حذف نهائي قطعي من قاعدة البيانات
     */
    public function forceDelete($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->forceDelete();
        return redirect()->route('tasks.trashed')->with('success', 'تم حذف المهمة نهائياً وبشكل قطعي.');
    }
}
