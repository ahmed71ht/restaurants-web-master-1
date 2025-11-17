<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي</title>
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

<div class="max-w-5xl mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">جميع الطلبات</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    @foreach($orders as $order)
        <div class="card-360 p-6 mb-6 bg-white shadow-md">
            <h2 class="text-xl font-bold mb-4">طلب رقم #{{ $order->id }}</h2>

            <ul class="mb-4">
                @foreach($order->foods as $food)
                    <li class="flex justify-between mb-2">
                        <span>{{ $food->name }} × {{ $food->pivot->quantity }} ({{ number_format($food->price, 0, '.', ',') }} ليرة)</span>
                        <span>السعر: {{ number_format($food->pivot->quantity * $food->price, 0, '.', ',') }} ليرة</span>
                    </li>
                @endforeach
            </ul>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                @if($order->status == 'pending')
                    <div class="flex items-center justify-between w-full bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                        <span class="text-yellow-700 font-semibold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            الطلب قيد الانتظار — يمكنك التعديل أو الحذف
                        </span>

                        <div class="flex gap-2">
                            <a href="{{ route('restaurant.user.edit', ['restaurant' => $restaurant->id, 'order' => $order->id]) }}"
                            class="bg-yellow-400 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-yellow-500 transition">
                                تعديل الطلب
                            </a>

                            <form action="{{ route('order.delete', $order->id) }}" method="POST"
                                onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-red-700 transition">
                                    حذف الطلب
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                @if($order->status == 'accepted')
                    <div class="flex items-center w-full bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                        <span class="text-green-700 font-semibold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            تم قبول الطلب — لا يمكن التعديل أو الحذف
                        </span>
                    </div>
                @endif

                @if($order->status == 'rejected')
                    <div class="flex items-center justify-between w-full bg-red-50 border border-red-200 rounded-lg p-3 mb-3">
                        <span class="text-red-700 font-semibold flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                            </svg>
                            تم رفض الطلب — لا يمكن إجراء أي تغييرات
                        </span>

                        <form action="{{ route('order.delete', $order->id) }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-red-700 transition">
                                حذف الطلب
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            

        </div>
    @endforeach
</div>

</body>
</html>
