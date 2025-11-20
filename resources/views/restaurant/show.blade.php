<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $restaurant->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: "Tajawal", sans-serif; background: #f6f7fb; margin:0; color:#222; }
        .header { background: linear-gradient(135deg, #ff8c00, #ff6b00); padding:60px 20px; text-align:center; color:#fff; border-bottom-left-radius:45px; border-bottom-right-radius:45px; box-shadow:0 8px 25px rgba(0,0,0,0.15); }
        .header h1 { font-size:44px; margin:0; font-weight:900; letter-spacing:1px; }
        .subheader { margin-top:10px; font-size:19px; opacity:0.95; }
        .container { max-width:1300px; margin:40px auto; padding:0 25px; position:relative; }
        .btn { display:inline-block; padding:12px 20px; border-radius:12px; font-weight:700; text-decoration:none; color:#fff; background: linear-gradient(to right,#ff8c00,#e57700); box-shadow:0 4px 12px rgba(0,0,0,0.15); transition:all .2s; cursor:pointer }
        .btn.secondary { background:#fff; color:#ff8c00; border:2px solid #ff8c00 }
        .restaurant-img { width:100%; height:380px; object-fit:cover; border-radius:20px; box-shadow:0 6px 25px rgba(0,0,0,0.2); margin-bottom:25px; }
        .location { background:#fff; border-right:6px solid #ff8c00; padding:12px 18px; border-radius:12px; font-size:18px; margin-bottom:20px; color:#444; box-shadow:0 3px 10px rgba(0,0,0,0.07); }
        .grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(300px,1fr)); gap:28px; margin-top:15px; }
        .card { background:#fff; border-radius:18px; overflow:hidden; border:1px solid #ffe0b2; box-shadow:0 6px 18px rgba(0,0,0,0.08); transition:all .25s; }
        .card:hover { transform:translateY(-6px); box-shadow:0 10px 30px rgba(0,0,0,.18); }
        .img-box img { width:100%; height:210px; object-fit:cover; }
        .content { padding:18px; }
        .food-name { font-size:20px; font-weight:800; color:#ff7a00; }
        .food-desc { margin-top:8px; color:#555; line-height:1.6; height:60px; overflow:hidden; }
        .price-box { display:flex; justify-content:space-between; align-items:center; margin-top:14px; font-size:16px; }
        /* Modal */
        .modal-wrap { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:2000; justify-content:center; align-items:center; }
        .modal { background:#fff; width:360px; border-radius:14px; padding:18px; box-shadow:0 10px 30px rgba(0,0,0,0.25); text-align:center; }
        .modal img { width:100%; height:170px; object-fit:cover; border-radius:10px; }
        .modal h3 { margin:12px 0 6px; font-size:20px; font-weight:900; color:#333; }
        .modal p { margin:6px 0; color:#444; }
        .qty { width: 95%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; font-size: 16px; text-align: center; left: 2px; position: relative; }
        /* Cart sidebar */
        #cartBox { position:fixed; bottom:20px; left:20px; z-index:3000; background:#fff; width:340px; max-height:70vh; overflow:auto; padding:14px; border-radius:14px; box-shadow:0 8px 30px rgba(0,0,0,0.18); }
        #cartBox h4 { margin:0 0 8px; font-size:18px; font-weight:900; color:#333; display:flex; justify-content:space-between; align-items:center; }
        .cart-item { background:#fbfbfb; padding:10px; border-radius:10px; margin-bottom:10px; font-size:14px; }
        .cart-actions { display:flex; gap:8px; margin-top:8px; }
        .small { padding:8px 10px; border-radius:8px; font-weight:700; cursor:pointer; border:none; }
        .danger { background:#ef4444; color:#fff }
        .primary { background:#ff7a00; color:#fff }
        .empty-box { text-align:center; background:#fff; border-radius:16px; padding:40px; font-size:18px; color:#777; box-shadow:0 5px 15px rgba(0,0,0,0.06); }
        @media (max-width:900px){ #cartBox{ right:10px; width:300px } .modal{ width:92% } }
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

        @if(auth()->check() && (auth()->id() === $restaurant->delivery_id || auth()->user()->role === 'admin'))
            <a href="{{ route('restaurant.delivery.index', $restaurant->id) }}" class="btn">طلبات المقبولة</a>
            <br><br>
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
                                <span>{{ number_format($food->price, 2) }} ₺</span>
                            </div>

                            <!-- زر الشراء يفتح المودال -->
                            <button
                                class="btn"
                                onclick='openBuyModal(@json($food))'
                                style="margin-top:14px;">
                                شراء
                            </button>

                            @if(auth()->check() && (auth()->id() === $restaurant->owner_id || auth()->user()->role === 'admin'))
                                <a
                                    href="{{ route('food.edit', $food->id) }}"
                                    class="btn"
                                    style="margin-top:14px;">
                                    تعديل
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Modal Buy -->
    <div id="buyModal" class="modal-wrap">
        <div class="modal" role="dialog" aria-modal="true">
            <img id="modalImage" src="" alt="صورة المنتج">
            <h3 id="modalName"></h3>
            <p>السعر: <strong id="modalPrice"></strong> ₺</p>

            <label style="display:block; margin-top:8px; text-align:right">الكمية</label>
            <input id="modalQuantity" class="qty" type="number" min="1" value="1">

            <div style="display:flex; gap:10px; margin-top:12px;">
                <button class="small primary" onclick="addToCart()">تم</button>
                <button class="small" onclick="closeModal()">إلغاء</button>
            </div>
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div id="cartBox" aria-live="polite">
        <h4>🛒 السلة <span id="cartCount" style="font-size:13px; font-weight:600; color:#666"></span></h4>
        <div id="cartItems"></div>

        <div class="cart-actions">
            <button class="small" onclick="clearCart()">تفريغ</button>
            <button class="small primary" onclick="confirmOrder()">تأكيد الشراء</button>
        </div>
        <div style="margin-top:8px; font-size:14px; color:#444">المجموع: <strong id="cartTotal">0</strong> ₺</div>
    </div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let cart = JSON.parse(sessionStorage.getItem('cart') || '[]');
let currentItem = null;

function openBuyModal(food) {
    console.log('فتح المودال:', food);
    currentItem = {
        id: food.id,
        restaurant_id: food.restaurant_id,
        name: food.name,
        price: parseFloat(food.price),
        image: food.image ? `{{ asset('') }}${food.image}` : ''
    };
    document.getElementById('modalName').innerText = food.name;
    document.getElementById('modalPrice').innerText = parseFloat(food.price).toFixed(2);
    document.getElementById('modalImage').src = currentItem.image;
    document.getElementById('modalQuantity').value = 1;
    document.getElementById('buyModal').style.display = 'flex';
}

function closeModal() { document.getElementById('buyModal').style.display = 'none'; currentItem = null; }

function addToCart() {
    if (!currentItem) return;
    let qty = parseInt(document.getElementById('modalQuantity').value) || 1;

    if (cart.length > 0 && cart[0].restaurant_id !== currentItem.restaurant_id) {
        if (!confirm('السلة تحتوي على أصناف من مطعم آخر. هل تريد تفريغ السلة واضافة هذا المنتج؟')) {
            closeModal();
            return;
        }
        cart = [];
    }

    let idx = cart.findIndex(i => i.id === currentItem.id);
    if (idx !== -1) { cart[idx].quantity += qty; }
    else { cart.push({ ...currentItem, quantity: qty }); }

    sessionStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
    closeModal();
}

function renderCart() {
    const box = document.getElementById('cartItems');
    const count = document.getElementById('cartCount');
    const totalEl = document.getElementById('cartTotal');
    box.innerHTML = '';

    if (cart.length === 0) { box.innerHTML = '<div style="padding:12px; color:#666">السلة فارغة</div>'; count.innerText = ''; totalEl.innerText = '0.00'; return; }

    let total = 0;
    cart.forEach(item => {
        total += item.price * item.quantity;
        box.innerHTML += `
            <div class="cart-item">
                <div style="display:flex; gap:10px; align-items:center">
                    <img src="${item.image || ''}" style="width:52px; height:52px; object-fit:cover; border-radius:8px;">
                    <div style="flex:1; text-align:right">
                        <div style="font-weight:800">${item.name}</div>
                        <div style="font-size:13px; color:#666">الكمية: ${item.quantity} • ${parseFloat(item.price).toFixed(2)} ₺</div>
                    </div>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:8px">
                    <div>
                        <button onclick="decreaseQty(${item.id})" class="small">−</button>
                        <button onclick="increaseQty(${item.id})" class="small">＋</button>
                    </div>
                    <button onclick="removeItem(${item.id})" class="small danger">حذف</button>
                </div>
            </div>
        `;
    });

    count.innerText = `(${cart.length})`;
    totalEl.innerText = total.toFixed(2);
}

function increaseQty(id) { const idx = cart.findIndex(i => i.id === id); if (idx !== -1) { cart[idx].quantity++; sessionStorage.setItem('cart', JSON.stringify(cart)); renderCart(); } }
function decreaseQty(id) { const idx = cart.findIndex(i => i.id === id); if (idx !== -1) { cart[idx].quantity = Math.max(1, cart[idx].quantity - 1); sessionStorage.setItem('cart', JSON.stringify(cart)); renderCart(); } }
function removeItem(id) { cart = cart.filter(i => i.id !== id); sessionStorage.setItem('cart', JSON.stringify(cart)); renderCart(); }
function clearCart() { if (!confirm('تفريغ السلة؟')) return; cart = []; sessionStorage.removeItem('cart'); renderCart(); }

async function confirmOrder() {
    if (cart.length === 0) {
        alert('السلة فارغة');
        return;
    }

    let phone = prompt('الرجاء إدخال رقم الهاتف للتواصل:');
    if (!phone) {
        alert('رقم الهاتف مطلوب');
        return;
    }

    // تحقق من أن الرقم 11 رقم بالضبط
    phone = phone.replace(/\D/g, ''); // إزالة أي حروف غير رقمية
    if (phone.length !== 11) {
        alert('رقم الهاتف يجب أن يكون 11 رقمًا بالضبط');
        return;
    }

    const location = prompt('مكان التوصيل (العنوان) (اختياري):', '') || '';

    try {
        const res = await fetch("{{ route('cart.checkout') }}", {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json' 
            },
            body: JSON.stringify({ items: cart, phone: phone, location: location })
        });

        if (!res.ok) {
            const err = await res.json().catch(()=>null);
            alert('حدث خطأ أثناء إرسال الطلب: ' + (err?.message || res.statusText));
            return;
        }

        const data = await res.json();
        alert('تم تأكيد الطلب! رقم الطلب: ' + (data.order_id ?? '—'));
        cart = [];
        sessionStorage.removeItem('cart');
        renderCart();
        if (data.redirect) window.location.href = data.redirect;
    } catch (e) {
        alert('خطأ بالشبكة: ' + e.message);
    }
}


renderCart();
</script>

</body>
</html>
