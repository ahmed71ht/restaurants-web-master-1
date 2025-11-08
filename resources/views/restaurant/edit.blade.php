@extends('layouts.admin')

@section('title','تعديل المطعم')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 mt-10 rounded shadow">
<div class="max-w-xl mx-auto bg-white p-10 mt-14 rounded-3xl shadow-2xl border border-gray-200">

    <h1 class="text-4xl font-extrabold mb-10 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent text-center">
        تعديل بيانات المطعم
    </h1>

    <form action="{{ route('restaurant.update', $restaurant->id) }}" method="POST" class="space-y-7">
        @csrf
        @method('PATCH')

        <div>
            <label class="block mb-2 font-medium text-gray-800">اسم المطعم</label>
            <input type="text" name="name" value="{{ $restaurant->name }}"
                   class="border border-gray-300 w-full p-3 rounded-xl  
                          focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-800">الموقع</label>
            <input type="text" name="location" value="{{ $restaurant->location }}"
                   class="border border-gray-300 w-full p-3 rounded-xl  
                          focus:ring-4 focus:ring-blue-300 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
        </div>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-lg transition-all duration-200 shadow-md hover:shadow-lg">
            <p style="color: black;">حفظ المطعم</p>
        </button>

    </form>

</div>

@endsection