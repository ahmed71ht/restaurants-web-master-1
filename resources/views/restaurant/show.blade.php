<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $restaurant->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Tajawal", sans-serif;
            background: #f6f7fb;
            margin: 0;
            padding: 0;
            color: #222;
        }

        /* ====== HEADER ====== */
        .header {
            background: linear-gradient(135deg, #ff8c00, #ff6b00);
            padding: 60px 20px;
            text-align: center;
            color: #fff;
            border-bottom-left-radius: 45px;
            border-bottom-right-radius: 45px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .header h1 {
            font-size: 44px;
            margin: 0;
            font-weight: 900;
            letter-spacing: 1px;
        }

        .subheader {
            margin-top: 10px;
            font-size: 19px;
            opacity: 0.9;
        }

        /* ====== CONTAINER ====== */
        .container {
            max-width: 1300px;
            margin: 50px auto;
            padding: 0 25px;
        }

        /* ====== BUTTONS ====== */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            color: #fff;
            background: linear-gradient(to right, #ff8c00, #e57700);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-4px);
            background: linear-gradient(to right, #e57700, #c96000);
        }

        .btn.secondary {
            background: #fff;
            color: #ff8c00;
            border: 2px solid #ff8c00;
        }

        .btn.secondary:hover {
            background: #ff8c00;
            color: #fff;
        }

        /* ====== IMAGE ====== */
        .restaurant-img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.2);
            margin-bottom: 25px;
        }

        /* ====== LOCATION ====== */
        .location {
            background: #fff;
            border-right: 6px solid #ff8c00;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 18px;
            margin-bottom: 40px;
            color: #444;
            box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        }

        /* ====== FOOD GRID ====== */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 35px;
        }

        .card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #ffe0b2;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        }

        .img-box img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .content {
            padding: 20px;
        }

        .food-name {
            font-size: 22px;
            font-weight: 800;
            color: #ff7a00;
        }

        .food-desc {
            margin-top: 10px;
            color: #555;
            line-height: 1.7;
            font-size: 15px;
            height: 65px;
            overflow: hidden;
        }

        .price-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
            font-size: 17px;
        }

        .price-box span:last-child {
            color: #ff7a00;
            font-weight: bold;
            font-size: 22px;
        }

        .empty-box {
            text-align: center;
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            font-size: 18px;
            color: #777;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 34px;
            }
            .restaurant-img {
                height: 260px;
            }
            .container {
                padding: 0 15px;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $restaurant->name }}</h1>
        <div class="subheader">{{ $restaurant->description }}</div>
    </div>

    <div class="container">
        <a href="{{ route('restaurant.index') }}" class="btn secondary">← رجوع</a>
        <br><br>

        @if($restaurant->image)
            <img src="{{ asset($restaurant->image) }}" alt="صورة المطعم" class="restaurant-img">
        @endif

        @if($restaurant->location)
            <div class="location">📍 الموقع: {{ $restaurant->location }}</div>
        @endif

        @if(auth()->check() && (auth()->id() === $restaurant->owner_id || auth()->user()->role === 'admin'))
            <a href="{{ route('restaurant.orders', $restaurant->id) }}" class="btn">الطلبات</a>
            <br><br>
        

            @if($restaurant->foods->count() < 8)
                <a href="{{ route('food.create', $restaurant->id) }}" class="btn">إضافة أكلة</a>
                <br><br>
            @endif

        @endif

        @if($restaurant->foods->count() == 0)
            <div class="empty-box">لا يوجد أطعمة بعد 🍽️</div>
        @else
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
                            <div class="price-box">
                                <span>السعر:</span>
                                <span>{{ number_format($food->price, 2) }}₺</span>
                            </div>
                            <a href="{{ route('food.buy', $food->id) }}" class="btn" style="margin-top:15px;">شراء</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>
</html>
