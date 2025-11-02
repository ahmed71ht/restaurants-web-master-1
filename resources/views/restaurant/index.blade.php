<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قائمة المطاعم</title>
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
            padding: 30px 0;
            text-align: center;
            color: white;
            font-size: 35px;
            font-weight: bold;
            margin-bottom: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        /* ================== GRID ================== */
        .container {
            padding: 30px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill,minmax(280px,1fr));
            gap: 25px;
        }

        /* ================== Card ================== */
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
            padding: 20px;
        }

        .name {
            font-size: 22px;
            font-weight: bold;
            color: #ff7a00;
        }

        .desc {
            margin-top: 10px;
            color: #3c3c3c;
            line-height: 1.6;
            font-size: 15px;
        }

    </style>
</head>
<body>

<div class="header">
    قائمة المطاعم
</div>

<div class="container">
    <div class="grid">
        @foreach($restaurants as $restaurant)
            <div class="card">
                @if($restaurant->image)
                <div class="img-box">
                    <img src="{{ asset($restaurant->image) }}" alt="صورة المطعم">
                </div>
                @endif
                <div class="content">
                    <div class="name">{{ $restaurant->name }}</div>
                    <div class="desc">{{ $restaurant->description }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
