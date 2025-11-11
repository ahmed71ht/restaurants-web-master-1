@extends('layouts.admin')

@section('title','قائمة المطاعم')

@section('content')

<div class="min-h-screen bg-gray-100 p-8">

    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow p-8">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800">قائمة المطاعم</h1>
            <a href="{{ route('restaurant.create') }}"
               class="px-5 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                + إضافة مطعم
            </a>
        </div>

        @if($restaurants->count())
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-100 text-right">
                    <th class="p-3 border-b">#</th>
                    <th class="p-3 border-b">الاسم</th>
                    <th class="p-3 border-b">العنوان</th>
                    <th class="p-3 border-b">الأكلات</th>
                    <th class="p-3 border-b">الإجراءات</th>
                </tr>
                </thead>

                <tbody>
                @foreach($restaurants as $restaurant)
                <tr class="border-b relative">
                    <td class="p-3">{{ $restaurant->id }}</td>
                    <td class="p-3">{{ $restaurant->name }}</td>
                    <td class="p-3">{{ $restaurant->location }}</td>

                    <!-- عمود الأكلات مع الانيميشن -->
                    <td class="p-3 relative">
                        <div x-data="{ open: false }" class="space-y-2 relative">

                            <button @click="open = !open"
                                    class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm mb-2">
                                <span x-show="!open">▼ عرض الأكلات</span>
                                <span x-show="open">▲ إخفاء الأكلات</span>
                            </button>

                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute top-full left-0 z-10 mt-1 w-96 bg-white rounded shadow-lg p-3">

                                @php
                                    $foods = \App\Models\Food::where('restaurant_id',$restaurant->id)->get();
                                @endphp

                                @if($foods->count())
                                    <div class="space-y-2 max-h-64 overflow-y-auto">
                                        @foreach($foods as $food)
                                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded shadow-sm">
                                                <div class="flex items-center gap-3">
                                                    <p class="font-semibold">{{ $food->name }}</p>
                                                    <p class="text-gray-600">{{ $food->price }} TL</p>
                                                </div>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('food.edit', ['food' => $food->id]) }}"
                                                       class="text-blue-600 hover:text-blue-800 text-sm">تعديل</a>
                                                    <form action="{{ route('food.destroy', ['restaurant' => $restaurant->id, 'food' => $food->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('متأكد بدك تحذف هذه الأكلة؟')"
                                                                class="text-red-600 hover:text-red-800 text-sm">
                                                            حذف
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">مافي أكلات لهذا المطعم</p>
                                @endif

                            </div>
                        </div>
                    </td>

                    <!-- عمود الإجراءات للمطعم -->
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('restaurant.edit', $restaurant->id) }}"
                           class="px-2 py-1 bg-blue-200 rounded text-blue-700 text-sm hover:bg-blue-300">
                            تعديل
                        </a>
                        <form action="{{ route('restaurant.destroy', $restaurant->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('متأكد بدك تحذف هذا المطعم؟')"
                                    class="px-2 py-1 bg-red-200 rounded text-red-700 text-sm hover:bg-red-300">
                                حذف
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
                </tbody>

            </table>

        @else
            <div class="text-center text-gray-600 mt-10">
                لا يوجد مطاعم مضافة بعد
            </div>
        @endif
    </div>
</div>
@endsection
