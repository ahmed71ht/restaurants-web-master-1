<!-- الكود القديم مع نافذة التعليقات الجديدة -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>{{ $restaurant->name }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
/* كل ستايلات القديم هنا بدون تغيير، باستثناء التعليقات */
body { font-family:"Tajawal",sans-serif; background:#f4f6fc; margin:0; color:#222; }
.header { background: linear-gradient(135deg, #ff8c00, #ff6b00); padding:70px 20px; text-align:center; color:#fff; border-bottom-left-radius:50px; border-bottom-right-radius:50px; box-shadow:0 10px 30px rgba(0,0,0,0.15); }
.header h1 { font-size:48px; margin:0; font-weight:900; letter-spacing:1px; }
.subheader { margin-top:12px; font-size:20px; opacity:0.95; }

/* زر التعليقات */
.comments-btn { padding: 10px 15px; background: #ff9800; color: #fff; border: none; border-radius: 6px; cursor: pointer; margin: 0 20px 20px 20px; display: block; }

/* مودال التعليقات الجديد */
.modal.comments-modal { position: fixed; bottom: -100%; left: 0; width: 100%; height: 75%; background: #fff; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.2); transition: bottom 0.3s ease; z-index: 99999; }
.modal.show { bottom: 0; }
.modal-content { height: 95%; display: flex; flex-direction: column; padding: 15px; }
.modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px; }
.close-btn { font-size: 25px; background: none; border: none; cursor: pointer; }
.comments-list { flex: 1; overflow-y: auto; margin: 15px 0; padding: 0 10px; }
.comment-item { padding: 10px; border-bottom: 1px solid #f1f1f1; background: #fafafa; border-radius: 10px; margin-bottom: 10px; text-align: right; }
.comment-item strong { color: #333; display: block; margin-bottom: 4px; }
.comment-form textarea { width: 100%; height: 70px; padding: 10px 6px; border: 1px solid #ddd; border-radius: 8px; }
.send-btn { width: 100%; margin-top: 10px; padding: 12px; background: #ff9800; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; }

body { font-family:"Tajawal",sans-serif; background:#f4f6fc; margin:0; color:#222; }
.header { background: linear-gradient(135deg, #ff8c00, #ff6b00); padding:70px 20px; text-align:center; color:#fff; border-bottom-left-radius:50px; border-bottom-right-radius:50px; box-shadow:0 10px 30px rgba(0,0,0,0.15); }
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
.modal { background:#fff; width:380px; border-radius:16px; box-shadow:0 12px 40px rgba(0,0,0,0.25); text-align:center; transition:all .3s; }
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

/* زر التعليقات */
.comments-btn { padding: 10px 15px; background: #ff9800; color: #fff; border: none; border-radius: 6px; cursor: pointer; margin: 0 20px 20px 20px; display: block; }

/* مودال التعليقات */
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
    <div class="restaurant-header">
        @if($restaurant->image)
        <img src="{{ asset($restaurant->image) }}" alt="{{ $restaurant->name }}" class="restaurant-img">
        @endif
        <button id="openComments" class="comments-btn">التعليقات 💬</button>
    </div>

    <a href="{{ route('restaurant.index') }}" class="btn secondary">← رجوع</a><br><br>

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

<!-- Modal Buy القديم -->
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

<!-- Cart Sidebar القديم -->
<div id="cartBox" aria-live="polite">
    <h4>🛒 السلة <span id="cartCount" style="font-size:13px; font-weight:600; color:#666"></span></h4>
    <div id="cartItems"></div>
    <div class="cart-actions">
        <button class="small" onclick="clearCart()">تفريغ</button>
        <button class="small primary" onclick="confirmOrder()">تأكيد الشراء</button>
    </div>
    <div style="margin-top:10px; font-size:15px; color:#444">المجموع: <strong id="cartTotal">0</strong> ₺</div>
</div>

<!-- Comments Modal الجديد -->
<div id="commentsModal" class="modal comments-modal">
    <div class="modal-content">

        <!-- العنوان والإغلاق -->
        <div class="modal-header">
            <h3>تعليقات المطعم</h3>
            <button id="closeComments" class="close-btn">&times;</button>
        </div>

        <!-- قائمة التعليقات -->
        <div class="comments-list">
            @foreach ($restaurant->comments as $comment)
            <div class="comment-item" style="background:#fafafa; padding:15px; border-radius:10px; margin-bottom:15px; border:1px solid #eee;">

                <strong style="font-size:15px;">
                    {{ $comment->user->name }}

                    @if($comment->isRestaurantOwner())
                        <span style="
                            background:#ff9800;
                            color:#fff;
                            padding:2px 6px;
                            border-radius:6px;
                            font-size:12px;
                            margin-right:6px;">
                            صاحب المطعم
                        </span>
                    @endif
                </strong>

                <!-- عرض التقييم -->
                @if($comment->rating > 0)
                    <div style="color:#f8b400; font-size:16px; margin-top:4px;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $comment->rating)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                @endif

                <p style="margin:6px 0 10px;">{{ $comment->comment }}</p>

                <!-- عرض صورة التعليق -->
                @if($comment->image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('comments/' . $comment->image) }}"
                             style="width:150px; border-radius:10px; border:1px solid #ccc; display:block;">
                    </div>
                @endif

                <!-- أزرار تعديل / حذف -->
                <div style="margin-bottom:10px;">
                    @if(auth()->check() && auth()->id() === $comment->user_id)
                        <button class="small primary" onclick='editComment(@json($comment->id), @json($comment->comment))'>
                            تعديل
                        </button>
                    @endif

                    @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->role === "admin" || auth()->id() === $restaurant->owner_id))
                        <form action="{{ route('comments.delete', $comment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="small danger">حذف</button>
                        </form>
                    @endif
                </div>

                <!-- زر عرض الردود -->
                <button class="small" id="toggle-btn-{{ $comment->id }}" onclick="toggleReplies({{ $comment->id }})">
                    عرض الردود
                </button>

                <!-- زر إضافة رد -->
                @auth
                    <button class="toggle-reply-btn small primary" style="margin-right:5px;">
                        إضافة رد
                    </button>

                    <!-- فورم الرد -->
                    <form action="{{ route('comments.reply', $comment->id) }}" method="POST" class="reply-form"
                          style="margin-top:10px; display:none; background:#f9f9f9; padding:10px; border-radius:8px;">
                        @csrf
                        <textarea name="reply" placeholder="اكتب ردك…" required
                                  style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;"></textarea>

                        <button class="toggle-reply-btn"
                                style="margin-top:10px; background:#eee; padding:6px 10px; border-radius:6px; cursor:pointer;">
                            إضافة رد
                        </button>
                    </form>
                @endauth

                <!-- صندوق الردود -->
                <div id="replies-{{ $comment->id }}" class="replies-box"
                     style="display:none; margin-top:15px; padding-right:15px; border-right:2px solid #ddd;">
                    @foreach($comment->replies as $reply)
                    <div class="reply-item"
                         style="background:#f7f7f7; padding:10px; border-radius:8px; margin-bottom:10px; border:1px solid #e5e5e5;">

                        <strong>{{ $reply->user->name }}</strong>
                        <p style="margin:4px 0;">{{ $reply->reply }}</p>

                        @if(auth()->check() && (auth()->id() === $reply->user_id || auth()->user()->role === 'admin' || auth()->id() === $restaurant->owner_id))
                        <div style="margin-top:6px;">
                            <button class="small primary"
                                    onclick="editReply({{ $reply->id }}, '{{ addslashes($reply->reply) }}')">تعديل</button>

                            <form action="{{ route('replies.destroy', $reply->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="small danger">حذف</button>
                            </form>
                        </div>
                        @endif

                    </div>
                    @endforeach
                </div>

            </div>
            @endforeach

        </div>

<!-- زر فتح الفورم -->
<button id="showCommentForm" class="small primary" style="margin-bottom:10px;">
    اكتب تعليق…
</button>

<!-- فورم التعليق مخفي افتراضيًا -->
<form id="commentForm" action="{{ route('restaurant.comments.store') }}" method="POST" enctype="multipart/form-data"
      class="comment-form"
      style="display:none; margin-top:15px; background:#fff; padding:15px; border-radius:10px; border:1px solid #eee;">
    @csrf
    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

    <!-- زر إلغاء -->
    <button type="button" id="cancelComment" class="small danger" style="margin-bottom:10px;">إلغاء</button>

    <!-- تقييم النجوم -->
    <div class="rating-box" style="margin-bottom:10px; text-align:center;">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>

        <input type="hidden" name="rating" id="rating" value="0">
    </div>

    <textarea name="comment" placeholder="أكتب تعليقك…" required
              style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;"></textarea>

    <!-- رفع صورة التعليق -->
    <label style="display:block; margin:10px 0 5px;">إضافة صورة للتعليق (اختياري):</label>
    <input type="file" name="image" accept="image/*"
           style="margin-bottom:10px; padding:6px; border:1px solid #ddd; border-radius:6px;">

    <button class="send-btn" style="margin-top:10px;">إرسال</button>
</form>

    </div>
</div>



<script>
// التعليقات من الجديد
const modal = document.getElementById("commentsModal");
document.getElementById("openComments").onclick = () => modal.classList.add("show");
document.getElementById("closeComments").onclick = () => modal.classList.remove("show");
window.onclick = e => { if(e.target === modal) modal.classList.remove("show"); };

// باقي السكربتات القديمة للشراء والسلة
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let cart = JSON.parse(sessionStorage.getItem('cart') || '[]');
let currentItem = null;

function openBuyModal(food){
    currentItem = {id:food.id, restaurant_id:food.restaurant_id, name:food.name, price:parseFloat(food.price), image:food.image ? `{{ asset('') }}${food.image}` : ''};
    document.getElementById('modalName').innerText = food.name;
    document.getElementById('modalPrice').innerText = parseFloat(food.price).toFixed(2);
    document.getElementById('modalImage').src = currentItem.image;
    document.getElementById('modalQuantity').value = 1;
    document.getElementById('buyModal').style.display = 'flex';
}

function closeModal(){ document.getElementById('buyModal').style.display='none'; currentItem=null; }

function addToCart(){
    if(!currentItem) return;
    let qty=parseInt(document.getElementById('modalQuantity').value)||1;
    if(cart.length>0 && cart[0].restaurant_id!==currentItem.restaurant_id){
        if(!confirm('السلة تحتوي على أصناف من مطعم آخر. هل تريد تفريغ السلة واضافة هذا المنتج؟')){ closeModal(); return; }
        cart=[];
    }
    let idx=cart.findIndex(i=>i.id===currentItem.id);
    if(idx!==-1) cart[idx].quantity+=qty;
    else cart.push({...currentItem, quantity:qty});
    sessionStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
    closeModal();
}

function renderCart(){
    const box=document.getElementById('cartItems');
    const count=document.getElementById('cartCount');
    const totalEl=document.getElementById('cartTotal');
    box.innerHTML='';
    if(cart.length===0){ box.innerHTML='<div style="padding:12px; color:#666">السلة فارغة</div>'; count.innerText=''; totalEl.innerText='0.00'; return; }
    let total=0;
    cart.forEach(item=>{
        total+=item.price*item.quantity;
        box.innerHTML+=`
        <div class="cart-item">
            <div style="display:flex; gap:10px; align-items:center">
                <img src="${item.image||''}" style="width:52px; height:52px; object-fit:cover; border-radius:8px;">
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
        </div>`;
    });
    count.innerText=`(${cart.length})`;
    totalEl.innerText=total.toFixed(2);
}

function increaseQty(id){ const idx=cart.findIndex(i=>i.id===id); if(idx!==-1){ cart[idx].quantity++; sessionStorage.setItem('cart', JSON.stringify(cart)); renderCart(); } }
function decreaseQty(id){
    const idx = cart.findIndex(i => i.id === id);
    if(idx !== -1){
        cart[idx].quantity = Math.max(1, cart[idx].quantity - 1);
        sessionStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }
}

function removeItem(id){
    cart = cart.filter(i => i.id !== id);
    sessionStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
}

document.querySelectorAll('.toggle-reply-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const form = btn.nextElementSibling; 
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
});


function clearCart(){ if(confirm('هل تريد تفريغ السلة؟')){ cart=[]; sessionStorage.setItem('cart', JSON.stringify(cart)); renderCart(); } } 

async function confirmOrder() {
    if (cart.length === 0) {
        alert('السلة فارغة');
        return;
    }

    // رقم الهاتف
    let phone = prompt('الرجاء إدخال رقم الهاتف للتواصل:');
    if (!phone) {
        alert('رقم الهاتف مطلوب');
        return;
    }
    phone = phone.replace(/\D/g, ''); // إزالة أي حروف غير رقمية
    if (phone.length !== 11) {
        alert('رقم الهاتف يجب أن يكون 11 رقمًا بالضبط');
        return;
    }

    // العنوان اختياري
    const location = prompt('مكان التوصيل (العنوان) (اختياري):') || '';

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
            const err = await res.json().catch(() => null);
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


// التعليقات
function editComment(id, text){
    const newComment = prompt('تعديل تعليقك:', text);
    if(newComment !== null && newComment.trim() !== ''){
        fetch(`/comments/${id}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ comment: newComment })
        })
        .then(res => res.json())
        .then(d => {
            if(d.success) location.reload();
            else alert('حدث خطأ بالتعديل');
        })
        .catch(() => alert('حدث خطأ بالتعديل'));
    }
}

function editReply(id, text){
    const newReply = prompt('تعديل ردك:', text);
    if(newReply !== null && newReply.trim() !== ''){
        fetch("{{ url('replies') }}/" + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ reply: newReply })
        })
        .then(res => res.json())
        .then(d => {
            if(d.success) location.reload();
            else alert(d.message || 'حدث خطأ بالتعديل');
        })
        .catch(() => alert('حدث خطأ بالتعديل'));
    }
}


function toggleReplies(id){
    const box = document.getElementById('replies-' + id);
    const btn = document.getElementById('toggle-btn-' + id);

    if(box.style.display === 'none'){
        box.style.display = 'block';
        btn.innerText = 'إخفاء الردود';
    } else {
        box.style.display = 'none';
        btn.innerText = 'عرض الردود';
    }
}


    const showBtn = document.getElementById('showCommentForm');
    const cancelBtn = document.getElementById('cancelComment');
    const form = document.getElementById('commentForm');

    // عرض الفورم عند الضغط على زر "اكتب تعليق"
    showBtn.addEventListener('click', () => {
        form.style.display = 'block';
        showBtn.style.display = 'none';
    });

    // إخفاء الفورم عند الضغط على زر "إلغاء"
    cancelBtn.addEventListener('click', () => {
        form.style.display = 'none';
        showBtn.style.display = 'inline-block';
    });

    // التعامل مع النجوم
    document.querySelectorAll(".rating-box .star").forEach(star => {
        star.addEventListener("click", function() {
            let value = this.getAttribute("data-value");
            document.getElementById("rating").value = value;

            document.querySelectorAll(".rating-box .star").forEach(s => s.style.color = "#ccc");

            for (let i = 0; i < value; i++) {
                document.querySelectorAll(".rating-box .star")[i].style.color = "#f8b400";
            }
        });
    });

// تحميل السلة عند فتح الصفحة
document.addEventListener('DOMContentLoaded', renderCart);
</script>
</body>
</html>
