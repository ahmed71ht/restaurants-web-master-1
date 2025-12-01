<!-- resources/views/restaurants/search.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>بحث عن مطعم</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Tajawal', sans-serif; background-color: #f3f4f6; }
    .card-shadow { 
        box-shadow: 0 10px 20px rgba(0,0,0,0.15); 
        transition: all 0.3s ease; 
    }
    .card-shadow:hover { 
        transform: translateY(-5px) scale(1.03); 
        box-shadow: 0 15px 25px rgba(0,0,0,0.25); 
    }

    /* From Uiverse.io by Admin12121 */ 
    .menu {
        padding: 0.5rem;
        background-color: #fff;
        position: relative;
        display: flex;
        justify-content: center;
        border-radius: 15px;
        box-shadow: 0 10px 25px 0 rgba(#000, 0.075);
    }

    .link {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 70px;
        height: 50px;
        border-radius: 8px;
        position: relative;
        z-index: 1;
        overflow: hidden;
        transform-origin: center left;
        transition: width 0.2s ease-in;
        text-decoration: none;
        color: inherit;
        &:before {
            position: absolute;
            z-index: -1;
            content: "";
            display: block;
            border-radius: 8px;
            width: 100%;
            height: 100%;
            top: 0;
            transform: translateX(100%);
            transition: transform 0.2s ease-in;
            transform-origin: center right;
            background-color: #eee;
        }

        &:hover,
        &:focus {
            outline: 0;
            width: 130px;

            &:before,
            .link-title {
                transform: translateX(0);
                opacity: 1;
                }
            }
        }

        .link-icon {
            width: 28px;
            height: 28px;
            display: block;
            flex-shrink: 0;
            left: 18px;
            position: absolute;

        svg {
            width: 28px;
            height: 28px;
        }
        }

        .link-title {
            transform: translateX(100%);
            transition: transform 0.2s 
                ease-in;
            transform-origin: center right;
            display: block;
            text-indent: 28px;
            width: 104%;
        }

</style>
</head>
<body>


    <!-- App Header -->
<header class="relative w-full bg-gradient-to-r from-orange-400 via-orange-500 to-yellow-400 text-white shadow-xl py-6">
    <div class="flex items-center justify-center text-3xl font-extrabold">
        🔍 بحث عن مطعم
    </div>

    @role('admin')
    <!-- زر الإعدادات بدون خلفية -->
    <a href="{{ route('admin.dashboard') }}" class="absolute top-7 left-4 text-white text-3xl hover:text-yellow-300 transition-all btn-animate">
        ⚙️
     </a>
    @endrole
</header>


<main class="p-6 max-w-7xl mx-auto mt-6">
            <!-- From Uiverse.io by Admin12121 --> 
        <div class="menu">
            <a href="{{ route('restaurant.index')  }}" class="link">
                <span class="link-icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="192"
                    height="192"
                    fill="currentColor"
                    viewBox="0 0 256 256"
                >
                    <rect width="256" height="256" fill="none"></rect>
                    <path
                    d="M213.3815,109.61945,133.376,36.88436a8,8,0,0,0-10.76339.00036l-79.9945,72.73477A8,8,0,0,0,40,115.53855V208a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V115.53887A8,8,0,0,0,213.3815,109.61945Z"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="16"
                    ></path>
                </svg>
                </span>
                <span class="link-title">Home</span>
            </a>
            <a href="{{ route('restaurant.top') }}" class="link">
                <span class="link-icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="192"
                    height="192"
                    fill="currentColor"
                    viewBox="0 0 256 256"
                >
                    <rect width="256" height="256" fill="none"></rect>
                    <polyline
                    points="76.201 132.201 152.201 40.201 216 40 215.799 103.799 123.799 179.799"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="16"
                    ></polyline>
                    <line
                    x1="100"
                    y1="156"
                    x2="160"
                    y2="96"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="16"
                    ></line>
                    <path
                    d="M82.14214,197.45584,52.201,227.397a8,8,0,0,1-11.31371,0L28.603,215.11268a8,8,0,0,1,0-11.31371l29.94113-29.94112a8,8,0,0,0,0-11.31371L37.65685,141.65685a8,8,0,0,1,0-11.3137l12.6863-12.6863a8,8,0,0,1,11.3137,0l76.6863,76.6863a8,8,0,0,1,0,11.3137l-12.6863,12.6863a8,8,0,0,1-11.3137,0L93.45584,197.45584A8,8,0,0,0,82.14214,197.45584Z"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="16"
                    ></path>
                </svg>
                </span>
                <span class="link-title">Top 10 Restaurant</span>
            </a>
            <a href="{{ route('restaurant.search') }}" class="link">
                <span class="link-icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="192"
                    height="192"
                    fill="currentColor"
                    viewBox="0 0 256 256"
                >
                    <rect width="256" height="256" fill="none"></rect>
                    <circle
                    cx="116"
                    cy="116"
                    r="84"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="16"
                    ></circle>
                    <line
                    x1="175.39356"
                    y1="175.40039"
                    x2="223.99414"
                    y2="224.00098"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="16"
                    ></line>
                </svg>
                </span>
                <span class="link-title">Search</span>
            </a>
            <a href="{{ route('dashboard') }}" class="link">
                <span class="link-icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="192"
                    height="192"
                    fill="currentColor"
                    viewBox="0 0 256 256"
                >
                    <rect width="256" height="256" fill="none"></rect>
                    <circle
                    cx="128"
                    cy="96"
                    r="64"
                    fill="none"
                    stroke="currentColor"
                    stroke-miterlimit="10"
                    stroke-width="16"
                    ></circle>
                    <path
                    d="M30.989,215.99064a112.03731,112.03731,0,0,1,194.02311.002"
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="16"
                    ></path>
                </svg>
                </span>
                <span class="link-title">Profile</span>
            </a>
        </div>
    <div class="container mx-auto p-6">

        <!-- نموذج البحث -->
        <form action="{{ route('restaurant.search') }}" method="GET" class="flex mb-6 justify-center">
            <input type="text" name="query" placeholder="ابحث باسم المطعم أو نوعه" 
                value="{{ request('query') }}"
                class="w-full md:w-1/2 p-4 rounded-l-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400">
            <button type="submit" class="bg-orange-500 text-white px-6 rounded-r-xl hover:bg-orange-600 transition">بحث</button>
        </form>

        <!-- نتائج البحث -->
        @if(isset($restaurants) && $restaurants->count() > 0)
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                @foreach($restaurants as $restaurant)
                    <div class="bg-white rounded-3xl overflow-hidden card-shadow restaurant-item border-4">
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
        @else
            <p class="text-gray-500 mt-4 text-center">لا توجد نتائج للبحث.</p>
        @endif
        
    </div>
</main>

</body>
</html>
