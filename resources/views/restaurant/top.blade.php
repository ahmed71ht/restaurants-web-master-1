<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أفضل 10 مطاعم للشهر</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #f3f4f6; }
        @layer utilities {
            .card-shadow { 
                box-shadow: 0 10px 20px rgba(0,0,0,0.15); 
                transition: all 0.3s ease; 
            }
            .card-shadow:hover { 
                transform: translateY(-5px) scale(1.03); 
                box-shadow: 0 15px 25px rgba(0,0,0,0.25); 
            }
            .btn-animate {
                transition: all 0.3s ease;
            }
            .btn-animate:hover {
                transform: scale(1.05);
            }
        }
    </style>
</head>
<body>

<!-- App Header -->
<header class="relative w-full bg-gradient-to-r from-orange-400 via-orange-500 to-yellow-400 text-white shadow-xl py-6">
    <div class="flex items-center justify-center text-3xl font-extrabold">
        🍽️ أفضل 10 مطاعم للشهر
    </div>

    @role('admin')
    <!-- زر الإعدادات -->
    <a href="{{ route('admin.dashboard') }}" class="absolute top-7 left-4 text-white text-3xl hover:text-yellow-300 transition-all btn-animate">
        ⚙️
    </a>
    @endrole
</header>

<main class="p-6 max-w-7xl mx-auto mt-6">

    <!-- Restaurants Grid -->
    <div id="restaurantsGrid" class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach($topRestaurants as $index => $restaurant)
        @php
            $borderColor = match($index) {
                0 => 'border-yellow-400',
                1 => 'border-gray-400',
                2 => '',
                default => 'border-white',
            };
        @endphp

        <div class="bg-white rounded-3xl overflow-hidden card-shadow restaurant-item border-4 {{ $borderColor }}">
            @if($restaurant->image)
            <div class="w-full h-48 overflow-hidden rounded-t-3xl">
                <img src="{{ asset($restaurant->image) }}" alt="صورة المطعم" class="w-full h-full object-cover">
            </div>
            @endif
            <div class="p-5">
                <h2 class="text-orange-500 font-bold text-xl mb-2 restaurant-name">{{ $restaurant->name }}</h2>
                <p class="text-gray-700 text-sm leading-relaxed mb-2">{{ $restaurant->description ?? 'لا يوجد وصف' }}</p>
                <p class="text-sm text-gray-500 mb-1">متوسط التقييم: {{ number_format($restaurant->avg_rating, 1) }} ⭐</p>
                <p class="text-sm text-gray-500 mb-1">عدد الطلبات: {{ $restaurant->total_orders }}</p>
                <p class="text-sm text-gray-500 mb-3">عدد التعليقات: {{ $restaurant->total_comments }}</p>
                <a href="{{ route('restaurant.show', $restaurant->id) }}" class="w-full inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl text-center btn-animate">
                    عرض التفاصيل
                </a>
            </div>
        </div>

        @endforeach
    </div>

    <!-- زر قائمة المطاعم الكاملة -->
    <div class="flex justify-center mt-4 mb-6">
        <a href="{{ route('restaurant.index') }}" 
        class="bg-white border border-orange-500 text-orange-500 font-semibold py-3 px-6 rounded-xl shadow-md hover:bg-orange-500 hover:text-white transition-all btn-animate">
            عرض جميع المطاعم
        </a>
    </div>


</main>

<script>
const searchInput = document.getElementById('restaurantSearch');
const restaurants = document.querySelectorAll('.restaurant-item');

searchInput.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    restaurants.forEach(item => {
        const name = item.querySelector('.restaurant-name').innerText.toLowerCase();
        if(name.includes(query)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
