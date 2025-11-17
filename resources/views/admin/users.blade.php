@extends('layouts.admin')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="container mx-auto mt-10">

    <h1 class="text-3xl font-bold mb-6 text-center">إدارة المستخدمين</h1>

    <div class="overflow-x-auto bg-white shadow-md rounded-xl">
        <table class="min-w-full border border-gray-200 text-right">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 border-b">#</th>
                    <th class="px-4 py-3 border-b">الاسم</th>
                    <th class="px-4 py-3 border-b">الإيميل</th>
                    <th class="px-4 py-3 border-b">الدور</th>
                    <th class="px-4 py-3 border-b">تم التحقق؟</th>
                    <th class="px-4 py-3 border-b">تحكم</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="px-4 py-3 border-b">{{ $user->id }}</td>
                    <td class="px-4 py-3 border-b">{{ $user->name }}</td>
                    <td class="px-4 py-3 border-b">{{ $user->email }}</td>
                    <td class="px-4 py-3 border-b">{{ $user->role ?? 'user' }}</td>
                    <td class="px-4 py-3 border-b">
                        @if($user->email_verified_at)
                            ✅ تم
                        @else
                            ❌ لا
                        @endif
                    </td>
                    <td class="px-4 py-3 border-b">
                        <button onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role ?? 'user' }}', {{ $user->email_verified_at ? 1 : 0 }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                            تعديل
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- رسالة تم الحفظ -->
<div id="saveMessage" 
     class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 opacity-0 transition-opacity duration-500">
    تم الحفظ بنجاح
</div>

<!-- Modal تعديل المستخدم -->
<!-- Modal تعديل المستخدم -->
<div id="editModal" 
     class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <div id="editModalContent" 
         class="bg-white rounded-2xl p-6 w-96 shadow-xl relative transform scale-90 transition-transform duration-300">
        <h2 class="text-xl font-semibold mb-4 text-center">تعديل المستخدم</h2>

        <form id="editForm" method="POST">
            @csrf
            <input type="hidden" name="id" id="user_id">

            <div class="mb-3">
                <label class="block mb-1">الاسم</label>
                <input type="text" name="name" id="name" class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label class="block mb-1">الإيميل</label>
                <input type="email" name="email" id="email" class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label class="block mb-1">الدور</label>
                <select name="role" id="role" class="w-full border rounded p-2">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block mb-1">كلمة المرور الجديدة</label>
                <input type="password" name="password" id="password" class="w-full border rounded p-2" placeholder="اتركه فارغ إذا لم ترغب بالتغيير">
            </div>

            <div class="mb-4 flex items-center gap-2">
                <input type="checkbox" name="verified" id="verified">
                <label for="verified">تم التحقق من البريد؟</label>
            </div>

            <div class="flex justify-between">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 px-3 py-2 rounded text-white">إلغاء</button>
                <button type="submit" class="bg-blue-600 px-3 py-2 rounded text-white">حفظ</button>
            </div>
        </form>
    </div>
</div>


<script>
function openEditModal(id, name, email, role, verified) {
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    modal.classList.remove('pointer-events-none');
    modal.classList.remove('opacity-0');
    content.classList.remove('scale-90');

    document.getElementById('editForm').action = `/restaurants-web-master-1/public/admin/dashboard/users/${id}`;
    document.getElementById('user_id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('email').value = email;
    document.getElementById('role').value = role ?? 'user';
    document.getElementById('verified').checked = verified ? true : false;
    document.getElementById('password').value = '';
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    const content = document.getElementById('editModalContent');

    content.classList.add('scale-90');
    modal.classList.add('opacity-0');

    setTimeout(() => {
        modal.classList.add('pointer-events-none');
    }, 300); // نفس مدة الانيميشن
}


// معالجة الفورم بدون إعادة تحميل الصفحة
document.getElementById('editForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const action = form.action;

    const res = await fetch(action, {
        method: 'POST',
        body: formData
    });

    if(res.ok){
        closeEditModal();

        // إظهار الرسالة تدريجيًا
        const msg = document.getElementById('saveMessage');
        msg.classList.remove('opacity-0'); // يظهر تدريجيًا
        msg.classList.add('opacity-100');

        // إخفاء الرسالة بعد 3 ثواني بتأثير تدريجي
        setTimeout(() => {
            msg.classList.remove('opacity-100');
            msg.classList.add('opacity-0');
        }, 3000);

        // تحديث الجدول مباشرة
        const id = formData.get('id');
        const row = Array.from(document.querySelectorAll('tbody tr')).find(r => r.children[0].textContent == id);
        if(row){
            row.children[1].textContent = formData.get('name');
            row.children[2].textContent = formData.get('email');
            row.children[3].textContent = formData.get('role');
            row.children[4].textContent = formData.get('verified') == 'on' ? '✅ تم' : '❌ لا';
        }
    }
});

</script>
@endsection
