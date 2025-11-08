<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $restaurant->name }}</title>
    <style>
        body {
            font-family: "Tajawal", sans-serif;
            background: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            background: linear-gradient(to right, #ff7a00, #d98b00);
            padding: 45px 20px;
            text-align: center;
            color: white;
            font-size: 38px;
            font-weight: 900;
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
            border-bottom-left-radius: 45px;
            border-bottom-right-radius: 45px;
        }

        .subheader {
            text-align: center;
            margin-top: 12px;
            font-size: 18px;
            color: #ffeec7;
        }

        .container {
            padding: 40px;
            max-width: 1300px;
            margin: auto;
        }

        .restaurant-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 18px;
            margin-bottom: 25px;
            box-shadow: 0 6px 22px rgba(0,0,0,0.20);
        }

        .location {
            font-size: 17px;
            color: #444;
            margin-bottom: 35px;
            background: #fff;
            padding: 10px 15px;
            border-right: 6px solid #ff7a00;
            border-radius: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(300px,1fr));
            gap: 30px;
            margin-top: 35px;
        }

        .card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #ffe6b7;
            transition: .25s;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.17);
        }

        .img-box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .content {
            padding: 20px;
        }

        .food-name {
            font-size: 21px;
            font-weight: 800;
            color: #d96b00;
        }

        .food-desc {
            margin-top: 12px;
            color: #333;
            line-height: 1.7;
            font-size: 15px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 12px 22px;
            background: #ff7a00;
            color: white;
            border-radius: 10px;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: .25s;
        }

        .back-btn:hover {
            background: #d96b00;
        }

        .buy-btn {
            display: inline-block;
            margin-top: 18px;
            padding: 10px 20px;
            background: linear-gradient(to right, #ff7a00, #d98b00);
            color: white;
            font-weight: bold;
            border-radius: 10px;
            text-decoration: none;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: .25s;
        }

        .buy-btn:hover {
            transform: translateY(-3px);
            background: linear-gradient(to right, #d96b00, #b87b00);
        }

    </style>
</head>
<body>

<div class="header">
    {{ $restaurant->name }}
    <div class="subheader">{{ $restaurant->description }}</div>
</div>

<div class="container">
    <a href="{{ route('restaurant.index') }}" class="back-btn">رجوع</a>

    @if($restaurant->image)
        <img src="{{ asset($restaurant->image) }}" alt="صورة المطعم" class="restaurant-img">
    @endif

    @if($restaurant->location)
        <div class="location">📍 الموقع: {{ $restaurant->location }}</div>
    @endif

    @roles('admin','owner')
        @if($restaurant->foods->count() < 3)
            <a href="{{ route('food.create', $restaurant->id) }}" class="back-btn">إضافة أكلة</a>
        @endif
    @endroles


    @if($restaurant->foods->count() == 0)
        <div style="text-align:center; font-size:19px; margin-top:40px; color:#666; padding:25px; background:white; border-radius:14px;">
            لا يوجد أطعمة بعد
        </div>
    @endif

    <div class="grid">
        @foreach($restaurant->foods as $food)
            <div class="card">
                @if($food->image)
                    <div class="img-box">
                        <img src="{{ asset($food->image) }}" alt="صورة {{ $food->name }}">
                    </div>
                @endif
                <div class="content">
                        <div class="food-name">{{ $food->name }}</div>
                        <div class="food-desc">{{ $food->description }}</div>
                        
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-gray-700 font-semibold text-lg">السعر:</span>
                            <span class="text-orange-600 font-bold text-2xl">
                                {{ number_format($food->price, 2) }}₺
                            </span>
                        </div>

                        <a href="{{ route('food.buy', $food->id) }}" class="buy-btn">شراء</a>
                    </div>
                </div>
        @endforeach
    </div>
</div>

</body>
</html>
