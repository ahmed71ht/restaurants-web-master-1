<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة المطاعم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* تعديل ألوان Tailwind حسب طلبك */
        @layer utilities {
            .bg-yellow-custom { background-color: #FFD966; }
            .text-orange-custom { color: #FF7F50; }
            .hover-bg-orange { background-color: #FF7F50; }
        }
    </style>
</head>
<body class="bg-white font-Tajawal">

    <!-- Header -->
    <header class="w-full bg-gradient-to-r from-orange-600 to-yellow-500 text-white text-center text-3xl font-bold py-8 shadow-md">
        قائمة المطاعم
    </header>

    <!-- Container -->
    <main class="p-8 max-w-7xl mx-auto">
        <div class="grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($restaurants as $restaurant)
            <!-- Card -->
            <div class="bg-yellow-custom border-2 border-orange-500 rounded-xl overflow-hidden shadow-lg transform transition-transform hover:scale-105">
                @if($restaurant->image)
                <div class="w-full h-48 overflow-hidden">
                    <img src="{{ asset($restaurant->image) }}" alt="صورة المطعم" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-5">
                    <h2 class="text-orange-custom font-bold text-xl">{{ $restaurant->name }}</h2>
                    <p class="text-gray-800 mt-2 text-sm leading-relaxed">{{ $restaurant->description }}</p>
                    <div class="mt-4">
                        <a href="{{ route('restaurant.show', $restaurant->id) }}" class="inline-block bg-orange-500 hover-bg-orange text-white py-2 px-4 rounded-lg transition-colors">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @role('admin')
        <div class="mt-10 text-center">
            <a href="{{ route('restaurant.create') }}" class="inline-block bg-orange-500 hover-bg-orange text-white py-3 px-6 rounded-xl font-semibold shadow-lg transition-colors">
                إضافة مطعم
            </a>
        </div>
        @endrole
    </main>

</body>
</html>
