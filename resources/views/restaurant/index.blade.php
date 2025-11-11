<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المطاعم</title>
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
            🍽️ قوائم المطاعم
        </div>

        @role('admin')
        <!-- زر الإعدادات بدون خلفية -->
        <a href="{{ route('admin.dashboard') }}" class="absolute top-7 left-4 text-white text-3xl hover:text-yellow-300 transition-all btn-animate">
            ⚙️
        </a>
        @endrole
    </header>

    <!-- Main Container -->
    <main class="p-6 max-w-7xl mx-auto mt-6">

        <!-- Restaurants Grid -->
        <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($restaurants as $restaurant)
            <div class="bg-white rounded-3xl overflow-hidden card-shadow">
                @if($restaurant->image)
                <div class="w-full h-48 overflow-hidden rounded-t-3xl">
                    <img src="{{ asset($restaurant->image) }}" alt="صورة المطعم" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-5">
                    <h2 class="text-orange-500 font-bold text-xl mb-2">{{ $restaurant->name }}</h2>
                    <p class="text-gray-700 text-sm leading-relaxed mb-4">{{ $restaurant->description }}</p>
                    <a href="{{ route('restaurant.show', $restaurant->id) }}" class="w-full inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl text-center btn-animate">
                        عرض التفاصيل
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @role('admin')
        <!-- زر إضافة مطعم -->
        <div class="mt-10">
            <a href="{{ route('restaurant.create') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white py-3 px-6 rounded-xl font-semibold shadow-lg btn-animate">
                إضافة مطعم
            </a>
        </div>
        @endrole

    </main>

</body>
</html>
