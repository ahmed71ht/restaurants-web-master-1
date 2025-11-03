<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $restaurant->name }}</title>
    <style>
        body {
            font-family: "Tajawal", sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* ================== Header ================== */
        .header {
            width: 100%;
            background: linear-gradient(to right, #ff7a00, #d98b00);
            padding: 40px 20px;
            text-align: center;
            color: white;
            font-size: 40px;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .subheader {
            text-align: center;
            margin-top: 10px;
            font-size: 18px;
            color: #fff9db;
        }

        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .restaurant-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 14px;
            margin-bottom: 20px;
        }

        .location {
            font-size: 16px;
            color: #3c3c3c;
            margin-bottom: 30px;
        }

        /* ================== Grid Products ================== */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(280px,1fr));
            gap: 25px;
        }

        .card {
            background: #fff9db;
            border-radius: 14px;
            border: 3px solid #ff7a00;
            overflow: hidden;
            transition: .25s;
        }

        .card:hover {
            transform: scale(1.04);
            box-shadow: 0px 0px 14px rgba(0,0,0,0.2);
        }

        .img-box img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .content {
            padding: 15px;
        }

        .food-name {
            font-size: 20px;
            font-weight: bold;
            color: #ff7a00;
        }

        .food-desc {
            margin-top: 8px;
            color: #3c3c3c;
            line-height: 1.5;
            font-size: 14px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #ff7a00;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: .25s;
        }

        .back-btn:hover {
            background: #d96b00;
        }
    </style>
</head>
<body>

<div class="header">
    {{ $restaurant->name }}
    <div class="subheader">{{ $restaurant->description }}</div>
</div>

<div class="container">
    <a href="{{ route('restaurant.index') }}" class="back-btn">رجوع لقائمة المطاعم</a>

    @if($restaurant->image)
        <img src="{{ asset('storage/'.$restaurant->image) }}" alt="صورة المطعم" class="restaurant-img">
    @endif

    @if($restaurant->location)
        <div class="location">الموقع: {{ $restaurant->location }}</div>
    @endif

    @if($restaurant->foods->count() == 0)
    <div style="text-align:center; font-size:18px; margin-top:30px; color:#888">
        لا يوجد أطعمة مضافة لهذا المطعم حالياً
        </div>
    @endif


    <div class="grid">
        @foreach($restaurant->foods as $food)
            <div class="card">
                @if($food->image)
                <div class="img-box">
                    <img src="{{ $food->image }}" alt="صورة {{ $food->name }}">
                </div>
                @endif
                <div class="content">
                    <div class="food-name">{{ $food->name }}</div>
                    <div class="food-desc">{{ $food->description }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
