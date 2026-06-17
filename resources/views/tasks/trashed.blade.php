<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>أرشيف المهام المحذوفة مؤقتاً</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-red-600">📂 أرشيف المهام المهملة (Soft Deleted)</h1>
            <a href="{{ route('tasks.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded font-semibold text-sm shadow">
                ⬅️ العودة للمهام النشطة
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4 text-sm font-medium">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow">
            <thead>
                <tr class="bg-red-900 text-white text-sm">
                    <th class="p-3 border border-gray-200">#</th>
                    <th class="p-3 border border-gray-200">عنوان المهمة</th>
                    <th class="p-3 border border-gray-200">اسم المستخدم</th>
                    <th class="p-3 border border-gray-200">اسم الفئة</th>
                    <th class="p-3 border border-gray-200">العمليات المتاحة</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr class="text-center text-sm border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-3">{{ $task->id }}</td>
                        <td class="p-3 text-gray-600 line-through">{{ $task->task_title }}</td>
                        <td class="p-3 font-semibold">{{ $task->user->name }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded text-white text-xs font-bold" style="background-color: '{{ $task->category->color }}'">
                                {{ $task->category->name }}
                            </span>
                        </td>
                        <td class="p-3 flex justify-center gap-2">
                            <form action="{{ route('tasks.restore', $task->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold shadow">
                                    استعادة
                                </button>
                            </form>

                            <form action="{{ route('tasks.forceDelete', $task->id) }}" method="POST" onsubmit="return confirm('تحذير: سيتم حذف المهمة بشكل قطعي ونهائي من قاعدة البيانات! هل أنت متأكد؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-black text-white hover:bg-gray-900 px-3 py-1 rounded text-xs font-semibold shadow">
                                    حذف قطعي
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-gray-500 text-center">الأرشيف فارغ تماماً حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
