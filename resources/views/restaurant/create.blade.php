<x-app-layout>

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

            <form action="{{ route('restaurant.store') }}" method="POST" enctype="multipart/form-data" class="space-y-7">
                @csrf

                <div class="space-y-1">
                    <label class="block font-semibold text-orange-700">صاحب المطعم (Owner)</label>
                    <select name="owner_id" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} (ID {{ $user->id }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="block font-semibold text-orange-700">اسم المطعم</label>
                    <input type="text" name="name" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0" required>
                </div>

                <div class="space-y-1">
                    <label class="block font-semibold text-orange-700">رفع صورة واحدة</label>
                    <input type="file" name="image" id="imageInput" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0">
                    <img id="imagePreview" style="max-width:200px;margin-top:10px;display:none;" class="rounded-lg shadow" />
                </div>

                <div class="space-y-1">
                    <label class="block font-semibold text-orange-700">الوصف</label>
                    <textarea name="description" rows="4" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0"></textarea>
                </div>

                <div class="space-y-1">
                    <label class="block font-semibold text-orange-700">الموقع</label>
                    <input type="text" name="location" class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0">
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl font-bold text-white text-lg bg-gradient-to-r
                        from-orange-600 to-yellow-500 hover:opacity-90 transition-all shadow-lg">
                    حفظ المطعم
                </button>

            </form>

        </div>

    </div>

    <script>
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

</x-app-layout>
