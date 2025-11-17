<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات التوصيل</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">

    <!-- رسالة النجاح في منتصف الشاشة -->
    @if(session('success'))
        <div id="successMessage" class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white font-medium px-6 py-2 rounded shadow-lg z-50 
            opacity-0 translate-y-[-10px] transition-all duration-500">
            {{ session('success') }}
        </div>

        <script>
            const msg = document.getElementById('successMessage');

            // إظهار الرسالة بسلاسة
            setTimeout(() => {
                msg.classList.remove('opacity-0', 'translate-y-[-10px]');
                msg.classList.add('opacity-100', 'translate-y-0');
            }, 100); // تأخير بسيط ليتم تطبيق transition

            // اختفاء الرسالة بعد 4 ثواني بسلاسة
            setTimeout(() => {
                msg.classList.remove('opacity-100', 'translate-y-0');
                msg.classList.add('opacity-0', 'translate-y-[-10px]');
                setTimeout(() => msg.remove(), 500); // إزالة العنصر بعد انتهاء الـ transition
            }, 4100);
        </script>
    @endif


    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow">

        <!-- العنوان مع زر الحذف على اليمين -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-indigo-600">
                طلبات التوصيل: <span class="font-black">{{ $restaurant->name }}</span>
            </h1>

            <!-- زر حذف الطلبات التي تم توصيلها -->
            <form action="{{ route('delivery.deleteDelivered', $restaurant->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-lg shadow transition duration-200">
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    حذف الطلبات المستلمة
                </button>
            </form>
        </div>

        <table class="w-full text-center border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr class="border-b">
                    <th class="p-3">#</th>
                    <th class="p-3">الأصناف</th>
                    <th class="p-3">السعر الكلي</th>
                    <th class="p-3">الزبون</th>
                    <th class="p-3">رقم الهاتف</th>
                    <th class="p-3">حالة التوصيل</th>
                    <th class="p-3">الإجراءات</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3">{{ $order->id }}</td>
                    <td class="p-3">{{ count($order->foods) }}</td>
                    <td class="p-3 font-semibold text-gray-700">{{ number_format($order->total_price, 2) }}</td>
                    <td class="p-3 font-medium">{{ $order->customer->name ?? 'غير معروف' }}</td>
                    <td class="p-3 font-medium">{{ $order->phone ?? 'غير متوفر' }}</td>
                    <td class="p-3">
                        @if($order->delivery_status === 'pending_delivery')
                            <span class="text-gray-700 font-bold">لم يبدأ التوصيل</span>
                        @elseif($order->delivery_status === 'on_the_way')
                            <span class="text-blue-600 font-bold">قيد التوصيل</span>
                        @elseif($order->delivery_status === 'delivered')
                            <span class="text-green-600 font-bold">تم التوصيل</span>
                        @endif
                    </td>
                    <td class="p-3">
                        <form action="{{ route('restaurant.delivery.updateStatus', [$restaurant, $order]) }}" method="POST" class="flex justify-center gap-2">
                            @csrf
                            <select name="delivery_status" class="border p-1 rounded">
                                <option value="pending_delivery" {{ $order->delivery_status=='pending_delivery'?'selected':'' }}>لم يبدأ</option>
                                <option value="on_the_way" {{ $order->delivery_status=='on_the_way'?'selected':'' }}>قيد التوصيل</option>
                                <option value="delivered" {{ $order->delivery_status=='delivered'?'selected':'' }}>تم التوصيل</option>
                            </select>
                            <button class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                                تحديث
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>
</html>
