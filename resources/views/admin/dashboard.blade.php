@extends('layouts.admin')

@section('title','لوحة تحكم المشرف')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Cards -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-sm text-gray-500">عدد المطاعم</h3>
        <div class="mt-3 flex items-center justify-between">
            <span class="text-3xl font-bold">{{ $restaurantsCount }}</span>
            <a href="{{ url('/admin/restaurants') }}" class="text-sm text-blue-600">إدارة</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-sm text-gray-500">عدد الأطعمة</h3>
        <div class="mt-3 flex items-center justify-between">
            <span class="text-3xl font-bold">{{ $foodsCount }}</span>
            <a href="{{ url('/admin/restaurants') }}" class="text-sm text-blue-600">عرض الأكل</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-sm text-gray-500">آخر مطعم أضيف</h3>
        <div class="mt-3">
            <p class="font-semibold">{{ $latestRestaurant ? $latestRestaurant->name : 'لا يوجد' }}</p>
            <p class="text-xs text-gray-400">{{ $latestRestaurant ? $latestRestaurant->created_at->format('Y-m-d H:i') : '' }}</p>
        </div>
    </div>

</div>

<!-- Charts + lists -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

    <!-- Chart -->
    <div class="col-span-2 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">عدد الأطعمة حسب المطعم (Top 10)</h3>
        <div id="chart" style="height: 360px;"></div>
    </div>

    <!-- Latest restaurants -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">آخر 10 مطاعم</h3>
        <ul class="space-y-3">
            @foreach($latestRestaurants as $rest)
                <li class="flex justify-between items-center">
                    <div>
                        <div class="font-medium">{{ $rest->name }}</div>
                        <div class="text-xs text-gray-400">{{ $rest->created_at->format('Y-m-d') }}</div>
                    </div>
                    <a href="{{ route('restaurant.edit', $rest->id) }}" class="text-sm text-blue-600">تعديل</a>
                </li>
            @endforeach
        </ul>
    </div>

</div>

<!-- Latest foods table -->
<div class="bg-white p-6 rounded-lg shadow mt-6">
    <h3 class="text-lg font-semibold mb-4">آخر 10 أكلات</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full text-right">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-xs text-gray-500">الاسم</th>
                    <th class="px-4 py-2 text-xs text-gray-500">المطعم</th>
                    <th class="px-4 py-2 text-xs text-gray-500">السعر</th>
                    <th class="px-4 py-2 text-xs text-gray-500">تاريخ الإضافة</th>
                    <th class="px-4 py-2 text-xs text-gray-500">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestFoods as $food)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ $food->name }}</td>
                    <td class="px-4 py-3">{{ $food->restaurant ? $food->restaurant->name : 'غير معروف' }}</td>
                    <td class="px-4 py-3">{{ $food->price ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $food->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('food.edit', $food->id) }}" class="text-sm text-blue-600">تعديل</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<!-- ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        var chartDom = document.getElementById('chart');
        var myChart = echarts.init(chartDom);

        var labels = {!! json_encode($foodsPerRestaurant->pluck('name')) !!};
        var values = {!! json_encode($foodsPerRestaurant->pluck('total')) !!};

        var option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: { type: 'shadow' }
            },
            xAxis: {
                type: 'category',
                data: labels,
                axisLabel: { rotate: 30, interval: 0 }
            },
            yAxis: { type: 'value' },
            series: [{
                data: values,
                type: 'bar',
                barWidth: '50%'
            }]
        };

        myChart.setOption(option);
        window.addEventListener('resize', function(){ myChart.resize(); });
    });
</script>
@endpush