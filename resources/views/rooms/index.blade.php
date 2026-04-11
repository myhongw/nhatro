<x-app-layout>
<div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-12 rounded-2xl mb-8 shadow">
    <div class="max-w-4xl mx-auto text-center">

        <h1 class="text-3xl font-bold mb-4">
            Tìm phòng trọ phù hợp với bạn 🏠
        </h1>

        <form method="GET" action="{{ route('rooms.index') }}"
              class="flex bg-white rounded-full overflow-hidden shadow-lg">

            <input 
                type="text" 
                name="search"
                value="{{ request('search') }}"
                placeholder="Nhập khu vực, giá, tên phòng..."
                class="flex-1 px-6 py-3 text-black outline-none"
            >

            <button class="bg-blue-600 hover:bg-blue-700 px-6 text-white font-semibold">
                Tìm kiếm
            </button>
        </form>

    </div>
</div>

<div class="max-w-7xl mx-auto px-6 flex flex-wrap items-center justify-between gap-4 mb-6">

    <form method="GET" class="flex gap-3 flex-wrap">
        <input type="hidden" name="search" value="{{ request('search') }}">

        <select name="price" class="border rounded-full px-4 py-2 text-sm">
            <option value="">💰 Giá</option>
            <option value="1" {{ request('price') == '1' ? 'selected' : '' }}>Dưới 2tr</option>
            <option value="2" {{ request('price') == '2' ? 'selected' : '' }}>2tr - 5tr</option>
            <option value="3" {{ request('price') == '3' ? 'selected' : '' }}>Trên 5tr</option>
        </select>

        <select name="sort" class="border rounded-full px-4 py-2 text-sm">
            <option value="">⚡ Sắp xếp</option>
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Giá thấp → cao</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Giá cao → thấp</option>
        </select>

        <button class="bg-gray-900 text-white px-4 py-2 rounded-full text-sm">
            Áp dụng
        </button>
    </form>

    <div class="text-sm text-gray-500">
        {{ $rooms->total() }} phòng được tìm thấy
    </div>

</div>

<div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach($rooms as $room)
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition overflow-hidden group">
                <div class="relative">
                    <img 
                        src="{{ $room->image ? asset('storage/'.$room->image) : 'https://via.placeholder.com/400x250' }}"
                        class="w-full h-48 object-cover group-hover:scale-110 transition duration-300">

                    <div class="absolute bottom-2 left-2 bg-white/90 px-3 py-1 rounded-full text-sm font-bold text-blue-600 shadow">
                        {{ number_format($room->price) }}đ
                    </div>
                </div>

                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600">
                        {{ $room->title }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        📍 {{ $room->address }}
                    </p>

                    <p class="text-sm text-gray-400 mt-2 line-clamp-2">
                        {{ $room->description }}
                    </p>

                    <div class="flex justify-between items-center mt-4">
                        <a href="{{ route('rooms.show', $room) }}"
                           class="text-blue-500 text-sm hover:underline">
                            Xem →
                        </a>

                        <button class="text-gray-400 hover:text-red-500" type="button">
                            ❤️
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $rooms->links() }}
    </div>
</div>
</x-app-layout>