<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة المهام - النشطة</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">📋 قائمة المهام النشطة</h1>
            <a href="{{ route('tasks.trashed') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold text-sm shadow">
                📂 عرض أرشيف المحذوفات
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow">
            <thead>
                <tr class="bg-gray-800 text-white text-sm">
                    <th class="p-3 border border-gray-200">#</th>
                    <th class="p-3 border border-gray-200">عنوان المهمة</th>
                    <th class="p-3 border border-gray-200">اسم المستخدم</th>
                    <th class="p-3 border border-gray-200">اسم الفئة</th>
                    <th class="p-3 border border-gray-200">الحالة</th>
                    <th class="p-3 border border-gray-200">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr class="text-center text-sm border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-3">{{ $task->id }}</td>
                        <td class="p-3 font-medium text-gray-700">{{ $task->task_title }}</td>
                        <td class="p-3 font-semibold">{{ $task->user->name }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded text-white text-xs font-bold" style="background-color: '{{ $task->category->color }}'">
                                {{ $task->category->name }}
                            </span>
                        </td>
                        <td class="p-3">
                            @if($task->status == 'completed')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">✅ مكتملة</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">⏳ معلقة</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من نقل هذه المهمة للأرشيف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold shadow">
                                    حذف مؤقت
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-gray-500 text-center">لا توجد مهام نشطة حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
