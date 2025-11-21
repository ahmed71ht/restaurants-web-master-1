<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>{{ $restaurant->name }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
body { font-family:"Tajawal",sans-serif; background:#f4f6fc; margin:0; color:#222; }
.header {
    background: linear-gradient(135deg, #ff8c00, #ff6b00);
    padding:70px 20px;
    text-align:center;
    color:#fff;
    border-bottom-left-radius:50px;
    border-bottom-right-radius:50px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
}
.header h1 { font-size:48px; margin:0; font-weight:900; letter-spacing:1px; }
.subheader { margin-top:12px; font-size:20px; opacity:0.95; }

.container { max-width:1300px; margin:40px auto; padding:0 25px; position:relative; }
.btn { display:inline-block; padding:14px 24px; border-radius:14px; font-weight:700; text-decoration:none; color:#fff; background: linear-gradient(to right,#ff8c00,#e57700); box-shadow:0 5px 20px rgba(0,0,0,0.15); transition:all .25s; cursor:pointer; }
.btn:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(0,0,0,0.2); }
.btn.secondary { background:#fff; color:#ff8c00; border:2px solid #ff8c00; }
.restaurant-img { width:100%; height:400px; object-fit:cover; border-radius:25px; box-shadow:0 8px 25px rgba(0,0,0,0.2); margin-bottom:30px; }

.location { background:#fff; border-right:6px solid #ff8c00; padding:14px 20px; border-radius:14px; font-size:18px; margin-bottom:25px; color:#444; box-shadow:0 4px 12px rgba(0,0,0,0.08); }

.grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:30px; margin-top:20px; }
.card { background:#fff; border-radius:20px; overflow:hidden; border:1px solid #ffe0b2; box-shadow:0 8px 25px rgba(0,0,0,0.1); transition:all .3s; }
.card:hover { transform:translateY(-8px); box-shadow:0 12px 35px rgba(0,0,0,.2); }
.img-box img { width:100%; height:220px; object-fit:cover; }
.content { padding:20px; }
.food-name { font-size:22px; font-weight:900; color:#ff7a00; }
.food-desc { margin-top:10px; color:#555; line-height:1.6; height:60px; overflow:hidden; }
.price-box { display:flex; justify-content:space-between; align-items:center; margin-top:16px; font-size:16px; }

.modal-wrap { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:2000; justify-content:center; align-items:center; }
.modal { background:#fff; width:380px; border-radius:16px; padding:20px; box-shadow:0 12px 40px rgba(0,0,0,0.25); text-align:center; transition:all .3s; }
.modal img { width:100%; height:180px; object-fit:cover; border-radius:12px; }
.modal h3 { margin:15px 0 8px; font-size:22px; font-weight:900; color:#333; }
.modal p { margin:8px 0; color:#444; font-size:16px; }
.qty { width: 95%; padding:12px; border-radius:10px; border:1px solid #ddd; font-size:16px; text-align:center; margin-top:6px; }

#cartBox { position:fixed; bottom:25px; left:25px; z-index:3000; background:#fff; width:360px; max-height:70vh; overflow:auto; padding:16px; border-radius:16px; box-shadow:0 12px 35px rgba(0,0,0,0.18); }
#cartBox h4 { margin:0 0 10px; font-size:20px; font-weight:900; color:#333; display:flex; justify-content:space-between; align-items:center; }
.cart-item { background:#fbfbfb; padding:12px; border-radius:12px; margin-bottom:12px; font-size:14px; }
.cart-actions { display:flex; gap:10px; margin-top:10px; }
.small { padding:8px 12px; border-radius:10px; font-weight:700; cursor:pointer; border:none; transition:all .2s; }
.small:hover { opacity:.9; }
.danger { background:#ef4444; color:#fff }
.primary { background:#ff7a00; color:#fff }

.empty-box { text-align:center; background:#fff; border-radius:20px; padding:50px; font-size:18px; color:#777; box-shadow:0 6px 20px rgba(0,0,0,0.08); }

@media (max-width:900px){
    #cartBox{ right:15px; width:320px }
    .modal{ width:94% }
}
</style>
</head>
<body>
<div class="header">
    <h1>{{ $restaurant->name }}</h1>
    <div class="subheader">{{ $restaurant->description }}</div>
    <div class="subheader">{{ $restaurant->phone }}</div>
</div>

<div class="container">
    <a href="{{ route('restaurant.index') }}" class="btn secondary">← رجوع</a><br><br>

    @if($restaurant->image)
    <img src="{{ asset($restaurant->image) }}" alt="صورة المطعم" class="restaurant-img">
    @endif

    @if($restaurant->location)
    <div class="location">📍 الموقع: {{ $restaurant->location }}</div>
    @endif

    <a href="{{ route('restaurant.user.orders', $restaurant->id) }}" class="btn">طلباتي</a><br><br>

    @if(auth()->check() && (auth()->id() === $restaurant->delivery_id || auth()->user()->role === 'admin'))
    <a href="{{ route('restaurant.delivery.index', $restaurant->id) }}" class="btn">طلبات المقبولة</a><br><br>
    @endif

    @if(auth()->check() && (auth()->id() === $restaurant->owner_id || auth()->user()->role === 'admin'))
    <a href="{{ route('restaurant.orders', $restaurant->id) }}" class="btn">الطلبات</a><br><br>
    @if($restaurant->foods->count() < 8)
    <a href="{{ route('food.create', $restaurant->id) }}" class="btn">إضافة أكلة</a><br><br>
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
                <button class="btn" onclick='openBuyModal(@json($food))' style="margin-top:16px;">شراء</button>
                @if(auth()->check() && (auth()->id() === $restaurant->owner_id || auth()->user()->role === 'admin'))
                <a href="{{ route('food.edit', $food->id) }}" class="btn" style="margin-top:16px;">تعديل</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Modal Buy -->
<div id="buyModal" class="modal-wrap">
    <div class="modal">
        <img id="modalImage" src="" alt="صورة المنتج">
        <h3 id="modalName"></h3>
        <p>السعر: <strong id="modalPrice"></strong> ₺</p>
        <label style="display:block; margin-top:10px; text-align:right">الكمية</label>
        <input id="modalQuantity" class="qty" type="number" min="1" value="1">
        <div style="display:flex; gap:12px; margin-top:14px; justify-content:center;">
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
    <div style="margin-top:10px; font-size:15px; color:#444">المجموع: <strong id="cartTotal">0</strong> ₺</div>
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
