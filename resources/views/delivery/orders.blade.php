<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات التوصيل</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<div class="max-w-3xl mx-auto my-10 px-4">
    <h1 class="text-2xl font-bold text-center text-blue-800 mb-8">طلبات التوصيل لمطعم {{ $restaurant->name }}</h1>

    @forelse ($orders as $order)
    <div class="bg-white rounded-xl shadow-md p-6 mb-6 hover:shadow-xl transition-shadow">
        <div class="flex justify-between items-center mb-3 font-semibold text-gray-700">
            <div>رقم الطلب: #{{ $order->id }}</div>
            <div class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>

        <div class="space-y-1 text-gray-700">
            <p><span class="font-semibold">العميل:</span> {{ $order->customer->name }}</p>
            <p><span class="font-semibold">العنوان:</span> {{ $order->address }}</p>
            <p><span class="font-semibold">المجموع:</span> {{ $order->total }} ريال</p>
            <p><span class="font-semibold">الحالة:</span> 
                @if($order->status == 'pending') بانتظار القبول
                @elseif($order->status == 'accepted') مقبول
                @else مرفوض
                @endif
            </p>
        </div>

        @if($order->status == 'pending')
        <div class="flex gap-3 mt-4">
            <form action="{{ route('restaurant.orders.accept', [$restaurant, $order]) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button class="w-full py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">قبول</button>
            </form>
            <form action="{{ route('restaurant.orders.reject', [$restaurant, $order]) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button class="w-full py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">رفض</button>
            </form>
        </div>
        @endif
    </div>
    @empty
    <div class="text-center text-gray-500 mt-16 text-lg">
        لا توجد طلبات حالياً.
    </div>
    @endforelse
</div>

</body>
</html>
