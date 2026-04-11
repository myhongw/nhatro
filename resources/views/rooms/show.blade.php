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
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-6">
            <a href="{{ route('rooms.index') }}" class="text-blue-600 hover:underline">
                ← Quay lại danh sách phòng
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                @php
                    $mainImage = $room->image
                        ? asset('storage/' . $room->image)
                        : 'https://via.placeholder.com/800x500';
                @endphp

                <!-- ẢNH LỚN -->
                <div class="overflow-hidden rounded-2xl shadow bg-white">
                    <img
                        id="main-room-image"
                        src="{{ $mainImage }}"
                        class="w-full h-[420px] object-cover transition duration-300"
                        alt="{{ $room->title }}"
                    >
                </div>

                <!-- THUMBNAILS -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-4">
                    <!-- Ảnh chính -->
                    <button
                        type="button"
                        class="room-thumb border-2 border-blue-500 rounded-xl overflow-hidden shadow-sm"
                        data-image="{{ $mainImage }}"
                    >
                        <img
                            src="{{ $mainImage }}"
                            class="w-full h-24 object-cover"
                            alt="Ảnh chính"
                        >
                    </button>

                    <!-- Ảnh detail -->
                    @foreach($room->images as $img)
                        <button
                            type="button"
                            class="room-thumb border-2 border-transparent hover:border-blue-400 rounded-xl overflow-hidden shadow-sm"
                            data-image="{{ asset('storage/' . $img->image) }}"
                        >
                            <img
                                src="{{ asset('storage/' . $img->image) }}"
                                class="w-full h-24 object-cover"
                                alt="Ảnh chi tiết"
                            >
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 space-y-5">

                <!-- TITLE -->
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    🏠 <span>{{ $room->title }}</span>
                </h1>

                <!-- PRICE -->
                <div class="flex items-center justify-between bg-blue-50 rounded-xl p-4">
                    <div class="flex items-center gap-2 text-blue-600 font-bold text-2xl">
                        💰 {{ number_format($room->price) }}đ
                    </div>

                    <span class="text-sm text-gray-500">
                        / tháng
                    </span>
                </div>

                <!-- INFO -->
                <div class="grid grid-cols-1 gap-3 text-gray-700 text-sm">

                    <div class="flex items-center gap-2">
                        📍 <span>{{ $room->address }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        ⚡ <span>Đăng hôm nay</span>
                    </div>

                    <div class="flex items-center gap-2">
                        🛏️ <span>Phòng đầy đủ tiện nghi</span>
                    </div>

                </div>

                <!-- DESCRIPTION -->
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2 flex items-center gap-2">
                        📝 Mô tả
                    </h3>

                    <p class="text-gray-600 leading-7 bg-gray-50 p-4 rounded-xl">
                        {{ $room->description }}
                    </p>
                </div>

                <!-- ACTION -->
                <div class="flex gap-3 pt-3">

                    <a href="tel:{{ $room->phone }}"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl font-semibold transition text-center">
                            📞 {{ $room->phone ?? 'Chưa cập nhật' }}
                        </a>

                    <button class="w-12 bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-500 rounded-xl text-xl transition">
                        ❤️
                    </button>

                </div>

            </div>
        </div>
    </div>

    <script>
        const mainRoomImage = document.getElementById('main-room-image');
        const thumbnails = document.querySelectorAll('.room-thumb');

        thumbnails.forEach((thumb) => {
            thumb.addEventListener('click', function () {
                const newImage = this.getAttribute('data-image');

                mainRoomImage.classList.add('opacity-60');
                mainRoomImage.src = newImage;

                setTimeout(() => {
                    mainRoomImage.classList.remove('opacity-60');
                }, 150);

                thumbnails.forEach(item => {
                    item.classList.remove('border-blue-500');
                    item.classList.remove('border-blue-400');
                    item.classList.add('border-transparent');
                });

                this.classList.remove('border-transparent');
                this.classList.add('border-blue-500');
            });
        });
    </script>
</x-app-layout>