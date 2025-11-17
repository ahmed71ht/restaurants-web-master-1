<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الطلب #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .card-360 {
            border-radius: 22px;
            backdrop-filter: blur(6px);
            transition: 0.4s ease-in-out;
        }
        .card-360:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen p-6">

<div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">تعديل أصناف الطلب #{{ $order->id }}</h2>

    {{-- عرض رسائل النجاح والخطأ --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update', [$restaurant->id, $order->id]) }}" method="POST">
        @csrf

        @foreach($order->foods as $food)
            <div class="card-360 p-4 mb-6 bg-gray-50 border rounded">
                <input type="hidden" name="order_food_id[]" value="{{ $food->pivot->id }}">

                <label class="block text-gray-700 font-medium mb-1">اختر الصنف</label>
                <select name="food_id[]" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 mb-2">
                    @foreach($restaurant->foods as $item)
                        <option value="{{ $item->id }}" {{ $food->id == $item->id ? 'selected' : '' }}>
                            {{ $item->name }} - {{ $item->price }} ليرة
                        </option>
                    @endforeach
                </select>

                <label class="block text-gray-700 font-medium mb-1">الكمية</label>
                <input type="number" name="quantity[]" value="{{ old('quantity.'.$loop->index, $food->pivot->quantity) }}" min="1" class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>
        @endforeach

        <div class="flex justify-end space-x-2 rtl:space-x-reverse">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">حفظ التعديلات</button>
            <a href="{{ route('restaurant.user.orders', $restaurant->id) }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">العودة للطلبات</a>
        </div>
    </form>
</div>

</body>
</html>
