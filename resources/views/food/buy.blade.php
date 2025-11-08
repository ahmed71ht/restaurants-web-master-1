@extends('layouts.admin')

@section('title','شراء الأكلة')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-6 sm:p-10 border border-orange-200">
        <h1 class="text-3xl font-extrabold mb-3 text-center text-orange-600">شراء {{ $food->name }}</h1>
        <p class="text-gray-600 text-center mb-7">أكمل بيانات الطلب أدناه</p>

        <div class="flex gap-6 items-center mb-8">
            <img src="{{ asset($food->image) }}" class="w-40 h-40 object-cover rounded-xl border border-orange-200 shadow-md">
            <div class="flex-1">
                <div class="text-xl font-bold text-orange-700">السعر: {{ number_format($food->price,2) }}$</div>
                <p class="text-gray-600 mt-2 leading-relaxed">{{ $food->description }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 p-4 text-green-800 bg-green-100 rounded-lg text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <form id="buyForm" method="POST" action="{{ route('food.buy.store',$food->id) }}" class="space-y-6">
            @csrf
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">الكمية</label>
                <input type="number" name="quantity" min="1" value="1" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0" required>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl font-bold text-white text-lg bg-gradient-to-r from-orange-600 to-yellow-500 hover:opacity-90 transition-all shadow-lg">
                تأكيد الطلب
            </button>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('buyForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // يمنع الفورم من الإرسال مباشرة
        const quantity = form.querySelector('input[name="quantity"]').value;

        if(confirm(`هل أنت متأكد أنك تريد طلب ${quantity} قطعة من {{ $food->name }}؟`)) {
            form.submit(); // يرسل الفورم إذا ضغط موافق
        }
    });
</script>
@endsection
