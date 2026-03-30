@extends('admin.layout')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">
            {{ isset($room) ? '✏️ Sửa phòng' : '➕ Thêm phòng' }}
        </h2>

        <a href="{{ route('admin.rooms.index') }}" class="text-gray-500 hover:text-black">
            ← Quay lại
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-2xl p-6">

        <form id="room-form" enctype="multipart/form-data">
            @csrf
            @if(isset($room)) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-6">

                <!-- IMAGE -->
                <div>
                    <label class="block mb-2 font-medium">Ảnh</label>

                    <img id="preview-image"
                        src="{{ isset($room) && $room->image ? asset('storage/'.$room->image) : 'https://via.placeholder.com/400x250' }}"
                        class="w-full h-48 object-cover rounded mb-2">

                    <input type="file" name="image" onchange="previewImage(event)">
                    <p class="text-red-500 text-sm error" data-error="image"></p>
                </div>

                <div>

                    <div class="mb-3">
                        <label>Tên</label>
                        <input name="title" value="{{ $room->title ?? '' }}" class="w-full border p-2 rounded">
                        <p class="text-red-500 text-sm error" data-error="title"></p>
                    </div>

                    <div class="mb-3">
                        <label>Giá</label>
                        <input name="price" id="price" value="{{ $room->price ?? '' }}" class="w-full border p-2 rounded">
                        <p class="text-red-500 text-sm error" data-error="price"></p>
                    </div>

                    <div class="mb-3">
                        <label>Địa chỉ</label>
                        <input name="address" value="{{ $room->address ?? '' }}" class="w-full border p-2 rounded">
                        <p class="text-red-500 text-sm error" data-error="address"></p>
                    </div>

                    <div class="mb-3">
                        <label>Mô tả</label>
                        <textarea name="description" class="w-full border p-2 rounded">{{ $room->description ?? '' }}</textarea>
                    </div>

                </div>

            </div>

            <button class="mt-4 bg-blue-600 text-white px-6 py-2 rounded">
                {{ isset($room) ? 'Cập nhật' : 'Thêm phòng' }}
            </button>

        </form>
    </div>
</div>

<script>

// preview image
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview-image').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

// format price
document.getElementById('price').addEventListener('input', function(e) {
    let priceInput = document.getElementById('price');

priceInput.addEventListener('input', function(e) {
    let raw = e.target.value.replace(/\D/g, '');

    e.target.dataset.raw = raw; // 🔥 lưu giá thật

    e.target.value = new Intl.NumberFormat('vi-VN').format(raw);
});
});

// AJAX SUBMIT
document.getElementById('room-form').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    formData.set('price', document.getElementById('price').dataset.raw || 0);

    document.querySelectorAll('.error').forEach(el => el.innerText = '');

    fetch("{{ isset($room) ? route('rooms.update', $room) : route('rooms.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: formData
    })
    .then(async res => {
        let data = await res.json();
        if (!res.ok) throw data;
        return data;
    })
    .then(data => {
        alert(data.message || 'Thành công');

        setTimeout(() => {
            window.location.href = "{{ route('admin.rooms.index') }}";
        }, 1000);
    })
    .catch(err => {

        if (err.errors) {
            for (let key in err.errors) {
                let el = document.querySelector(`[data-error="${key}"]`);
                if (el) el.innerText = err.errors[key][0];
            }
        } else {
            alert('Lỗi rồi');
        }
    });
});

</script>

@endsection