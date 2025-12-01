<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مطاعم أتابعها</title>
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
            .btn-animate { transition: all 0.3s ease; }
            .btn-animate:hover { transform: scale(1.05); }
        }
    </style>
</head>
<body>

<header class="relative w-full bg-gradient-to-r from-orange-400 via-orange-500 to-yellow-400 text-white shadow-xl py-6">
    <div class="flex items-center justify-center text-3xl font-extrabold">🍽️ المطاعم التي أتابعها</div>

    @role('admin')
    <a href="{{ route('admin.dashboard') }}" class="absolute top-7 left-4 text-white text-3xl hover:text-yellow-300 transition-all btn-animate">⚙️</a>
    @endrole
</header>

<main class="p-6 max-w-7xl mx-auto mt-6">

    <!-- إن لم يكن يتابع مطاعم -->
    @if($followingRestaurants->isEmpty())
        <div class="text-center text-gray-600 text-xl font-semibold py-10">
            لا تتابع أي مطعم حتى الآن 🤷‍♂️
        </div>
    @endif

    <!-- Grid -->
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        @foreach($followingRestaurants as $restaurant)
        <div class="bg-white rounded-3xl overflow-hidden card-shadow border-4 border-orange-300 restaurant-item">
            @if($restaurant->image)
            <div class="w-full h-48 overflow-hidden rounded-t-3xl">
                <img src="{{ asset($restaurant->image) }}" class="w-full h-full object-cover">
            </div>
            @endif
            <div class="p-5">
                <h2 class="text-orange-500 font-bold text-xl mb-2">{{ $restaurant->name }}</h2>
                <p class="text-gray-700 text-sm leading-relaxed mb-3">{{ $restaurant->description ?? 'لا يوجد وصف' }}</p>

                <div class="flex gap-2">
                    <a href="{{ route('restaurant.show', $restaurant->id) }}" 
                    class="flex-1 inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl text-center btn-animate">
                        عرض التفاصيل
                    </a>

                    @php
                        $isFollowing = auth()->user()->followedRestaurants->contains($restaurant->id);
                    @endphp

                    <button class="flex-1 py-3 rounded-xl font-semibold text-white btn-animate"
                            style="background-color: {{ $isFollowing ? '#ef4444' : '#3b82f6' }}"
                            onclick="toggleFollow({{ $restaurant->id }}, this)">
                        {{ $isFollowing ? 'إلغاء المتابعة' : 'متابعة' }}
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- زر الرجوع -->
    <div class="flex justify-center mt-6">
        <a href="{{ route('restaurant.index') }}" 
        class="bg-white border border-orange-500 text-orange-500 font-semibold py-3 px-6 rounded-xl shadow-md hover:bg-orange-500 hover:text-white transition-all btn-animate">
            الرجوع لقائمة المطاعم
        </a>
    </div>


    <script>
function toggleFollow(restaurantId, btn) {
    let isFollowing = btn.innerText === 'إلغاء المتابعة';
    let token = '{{ csrf_token() }}';
    let url = isFollowing 
        ? `/restaurants/${restaurantId}/unfollow` 
        : `/restaurants/${restaurantId}/follow`;
    let method = isFollowing ? 'DELETE' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.innerText = isFollowing ? 'متابعة' : 'إلغاء المتابعة';
            btn.style.backgroundColor = isFollowing ? '#3b82f6' : '#ef4444';
        }
    })
    .catch(err => console.error(err));
}
</script>

</main>

</body>
</html>
