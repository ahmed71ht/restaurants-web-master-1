<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة تحكم المشرف</title>
    <!-- Tailwind (إذا لم يكن مثبت عبر mix/vite) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('head')
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-72 bg-white border-r shadow-sm p-5">
            <h2 class="text-2xl font-bold mb-6">لوحة المشرف</h2>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100">الرئيسية</a>
                <a href="{{ route('admin.restaurants.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100">المطاعم</a>
                <a href="{{ route('restaurant.create') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100">إضافة مطعم</a>
                <a href="{{ route('admin.users') }}" class="block px-3 py-2 rounded-md hover:bg-gray-100">تحكم بالمستخدمين</a>
                <!-- أضف روابط إضافية هنا -->
            </nav>
        </aside>

        <!-- Content -->
        <main class="flex-1 p-8">
            <header class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-extrabold">@yield('title', 'لوحة التحكم')</h1>
                    <p class="text-sm text-gray-500">مرحباً، هنا تحكم كامل بالموقع والمطاعم.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('restaurant.index') }}" class="px-4 py-2 bg-gray-200 rounded">الذهاب للموقع</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">تسجيل خروج</button>
                    </form>
                </div>
            </header>

            <div class="space-y-6">
                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>