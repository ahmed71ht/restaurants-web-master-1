@extends('layouts.admin')

@section('title','تعديل الأكلة')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 mt-10 rounded shadow">
        <div class="max-w-xl mx-auto bg-white p-10 mt-14 rounded-3xl shadow-2xl border border-gray-200">

            <h1 class="text-4xl font-extrabold mb-10 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent text-center">
                تعديل بيانات المطعم
            </h1>

            <form action="{{ route('food.update', $food->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block mb-2 font-medium text-gray-800">اسم الأكلة</label>
                    <input type="text" name="name" value="{{ $food->name }}"
                        class="border border-gray-300 w-full p-3 rounded-xl  
                                focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                </div>

                <div>
                    <label class="block mb-2 font-medium text-gray-800">وصف الأكلة</label>
                    <input type="text" name="description" value="{{ $food->description }}"
                        class="border border-gray-300 w-full p-3 rounded-xl  
                                focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                </div>

                <div class="space-y-1">
                    <label class="block font-semibold text-orange-700">صورة الأكلة</label>
                    <input type="file" name="image" id="imageInput"
                        class="w-full border-2 border-orange-200 rounded-xl p-3 focus:border-orange-500 focus:ring-0">
                    <img id="imagePreview" style="max-width:200px;margin-top:10px;display:none;" class="rounded-lg shadow" />
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-md hover:shadow-lg">
                    <p style="color: black;">حفظ الأكلة</p>
                </button>

            </form>

        </div>

        <div>
</body>
</html>
