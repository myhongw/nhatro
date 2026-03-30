@extends('admin.layout')

@section('content')

<div class="p-2">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">🏠 Quản lý phòng</h2>

        <a href="{{ route('rooms.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
           ➕ Thêm phòng
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full table-fixed">

            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 w-[220px]">Ảnh</th>
                    <th class="w-[180px]">Tên</th>
                    <th class="w-[120px]">Giá</th>
                    <th class="w-[200px]">Địa chỉ</th>
                    <th>Mô tả</th>
                    <th class="w-[120px]">Hành động</th>
                </tr>
            </thead>

            <tbody>
                @foreach($rooms as $room)
                <tr class="border-t hover:bg-gray-50 transition text-center">

                    <!-- IMAGE -->
                    <td class="p-3">
                        <img 
                            src="{{ $room->image ? asset('storage/'.$room->image) : 'https://via.placeholder.com/200x100' }}"
                            class="w-[200px] h-[100px] object-cover rounded mx-auto">
                    </td>

                    <!-- TITLE -->
                    <td class="font-semibold">
                        {{ $room->title }}
                    </td>

                    <!-- PRICE -->
                    <td class="text-red-500 font-bold">
                        {{ number_format($room->price) }} đ
                    </td>

                    <!-- ADDRESS -->
                    <td class="text-gray-600">
                        {{ $room->address }}
                    </td>

                    <!-- DESCRIPTION -->
                    <td class="text-sm text-gray-500 px-2">
                        <div class="line-clamp-2">
                            {{ $room->description }}
                        </div>
                    </td>

                    <!-- ACTION -->
                    <td>
                        <div class="flex justify-center gap-3 text-lg">

                            <a href="{{ route('rooms.edit', $room) }}" 
                               class="text-yellow-500 hover:scale-110 transition">
                               ✏️
                            </a>

                            <form action="{{ route('rooms.destroy', $room) }}" method="POST"
                                  onsubmit="return confirm('Bạn chắc chắn xóa?')">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-500 hover:scale-110 transition">
                                    🗑️
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>

@endsection