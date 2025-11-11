<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة طعام جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="min-h-screen bg-gray-100 p-8">
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow p-8">

            <h1 class="text-3xl font-bold text-gray-800 mb-6">طلبات مطعم: {{ $restaurant->name }}</h1>

            @if($orders->count())
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-right">
                            <th class="p-3 border-b">#</th>
                            <th class="p-3 border-b">الأصناف</th>
                            <th class="p-3 border-b">الكمية الكلية</th>
                            <th class="p-3 border-b">الزبون</th>
                            <th class="p-3 border-b">الحالة</th>
                            <th class="p-3 border-b">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $totalQuantity = $order->foods->sum(function($food) {
                                    return $food->pivot->quantity;
                                });
                            @endphp
                            <tr class="border-b hover:bg-gray-50 align-top">
                                <td class="p-3">{{ $order->id }}</td>

                                <td class="p-3">
                                    <ul class="list-disc list-inside">
                                        @foreach($order->foods as $food)
                                            <li>{{ $food->name }} ({{ $food->pivot->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td class="p-3">{{ $order->total_price }}</td>

                                <td class="p-3">{{ $order->customer->name ?? 'مجهول' }}</td>

                                <td class="p-3">
                                    @if($order->status == 'pending')
                                        <span class="text-yellow-600 font-semibold">قيد الانتظار</span>
                                    @elseif($order->status == 'accepted')
                                        <span class="text-green-600 font-semibold">مقبول</span>
                                    @else
                                        <span class="text-red-600 font-semibold">مرفوض</span>
                                    @endif
                                </td>

                                <td class="p-3 flex space-x-2">
                                    @if($order->status == 'pending')
                                        <form action="{{ route('restaurant.orders.accept', ['restaurant' => $restaurant->id, 'order' => $order->id]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                                                قبول
                                            </button>
                                        </form>

                                        <form action="{{ route('restaurant.orders.reject', ['restaurant' => $restaurant->id, 'order' => $order->id]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                                رفض
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">لا يوجد إجراءات</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center text-gray-600 mt-10">
                    لا يوجد طلبات لهذا المطعم حتى الآن
                </div>
            @endif
        </div>
    </div>

</body>
</html>

