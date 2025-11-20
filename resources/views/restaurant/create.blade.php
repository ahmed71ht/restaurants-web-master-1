@extends('layouts.admin')

@section('title','إنشاء المطعم')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-6 sm:p-10 border border-orange-200">
        <h1 class="text-3xl font-extrabold mb-10 text-center text-orange-600">
            إضافة مطعم جديد
        </h1>

        @if(session('success'))
            <div class="mb-5 p-4 text-green-800 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="flex items-start text-red-600">
                            <span class="w-2 h-2 mt-2 mr-2 bg-red-600 rounded-full flex-shrink-0"> </span>
                            <span> {{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('restaurant.store') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
            @csrf

            <!-- Owner -->
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">صاحب المطعم (Owner)</label>
                <select name="owner_id" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0 select-search">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('owner_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} (ID {{ $user->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Phone -->
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">رقم المطعم</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0" required>

            </div>

            <!-- Delivery -->
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">مسؤول التوصيل (Delivery)</label>
                <select name="delivery_id" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0 select-search">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('delivery_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} (ID {{ $user->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Name -->
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">اسم المطعم</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0" required>
            </div>

            <!-- Image -->
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">رفع صورة واحدة</label>
                <input type="file" name="image" id="imageInput"
                       class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0">
                <img id="imagePreview" style="max-width:200px;margin-top:10px;display:none;" class="rounded-lg shadow" />
            </div>

            <!-- Description -->
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">الوصف</label>
                <textarea name="description" rows="4"
                          class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0">{{ old('description') }}</textarea>
            </div>

            <!-- Location -->
            <div class="space-y-1">
                <label class="block font-semibold text-orange-700">الموقع</label>
                <input type="text" name="location" value="{{ old('location') }}"
                       class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0">
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full py-3 rounded-xl font-bold text-white text-lg bg-gradient-to-r
                    from-orange-600 to-yellow-500 hover:opacity-90 transition-all shadow-lg">
                    <p style="color: black;">حفظ المطعم</p>
            </button>
        </form>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // تفعيل Select2 للبحث
    $(document).ready(function() {
        $('.select-search').select2({
            placeholder: "اختر من القائمة",
            allowClear: true,
            width: '100%'
        });
    });

    // عرض الصورة قبل الرفع
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<!-- CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection
